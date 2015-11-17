<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_Forms extends NF_Abstracts_Menu
{
    public $page_title = 'Forms';

    public $menu_slug = 'ninja-forms';

    public $icon_url = 'dashicons-feedback';

    public function __construct()
    {
        parent::__construct();

        if( ! defined( 'DOING_AJAX' ) ) {
            add_action('admin_init', array($this, 'admin_init'));
            add_action( 'admin_init', array( 'NF_Admin_AllFormsTable', 'process_bulk_action' ) );
        }
    }

    public function display()
    {
        if( isset( $_GET[ 'form_id' ] ) && $_GET[ 'form_id' ] ){

            /*
             * FORM BUILDER
             */

            Ninja_Forms::template( 'admin-menu-new-form.html.php' );
            wp_enqueue_style( 'nf-builder', Ninja_Forms::$url . 'assets/css/builder.css' );

            wp_enqueue_script( 'backbone-marionette', Ninja_Forms::$url . 'assets/js/lib/backbone.marionette.min.js', array( 'jquery', 'backbone' ) );
            wp_enqueue_script( 'backbone-radio', Ninja_Forms::$url . 'assets/js/lib/backbone.radio.min.js', array( 'jquery', 'backbone' ) );
            wp_enqueue_script( 'backbone-undo', Ninja_Forms::$url . 'assets/js/lib/backbone.undo.js', array( 'jquery', 'backbone' ) );
            wp_enqueue_script( 'jquery-perfect-scrollbar', Ninja_Forms::$url . 'assets/js/lib/perfect-scrollbar.jquery.min.js', array( 'jquery' ) );
            wp_enqueue_script( 'jquery-hotkeys-new', Ninja_Forms::$url . 'assets/js/lib/jquery.hotkeys.js' );

            wp_enqueue_script( 'requirejs', Ninja_Forms::$url . 'assets/js/lib/require.js', array( 'jquery', 'backbone' ) );
            wp_enqueue_script( 'nf-builder', Ninja_Forms::$url . 'assets/js/builder/main.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-droppable', 'jquery-ui-sortable' ) );

            wp_localize_script( 'nf-builder', 'nfAdmin', array( 'ajaxNonce' => wp_create_nonce( 'ninja_forms_ajax_nonce' ), 'requireBaseUrl' => Ninja_Forms::$url . 'assets/js/', 'previewurl' => site_url() . '/?nf_preview_form=' . $_GET[ 'form_id' ] ) );

            delete_user_option( get_current_user_id(), 'nf_form_preview_' . $_GET[ 'form_id' ] );

            $this->_localize_form_data( $_GET[ 'form_id' ] );

            $this->_localize_field_type_data();

            $this->_localize_action_type_data();
        } else {

            /*
             * ALL FORMS TABLE
             */

            $this->table->prepare_items();

            Ninja_Forms::template( 'admin-menu-all-forms.html.php', array( 'table' => $this->table ) );
        }
    }

    public function admin_init()
    {
        $this->table = new NF_Admin_AllFormsTable();
    }

    public function submenu_separators()
    {
        add_submenu_page( 'ninja-forms', '', '', 'read', '', '' );
    }

    private function _localize_form_data( $form_id )
    {
        $form = Ninja_Forms()->form( $form_id )->get();
        $fields = Ninja_Forms()->form( $form_id )->get_fields();
        $actions = Ninja_Forms()->form( $form_id )->get_actions();

        $fields_settings = array();

        foreach( $fields as $field ){
            $settings = $field->get_settings();
            $settings[ 'id' ] = $field->get_id();

            foreach( $settings as $key => $setting ){
                if( is_numeric( $setting ) ) $settings[ $key ] = absint( $setting );
            }

            $fields_settings[] = $settings;
        }

        $actions_settings = array();

        foreach( $actions as $action ){
            $actions_settings[] = $action->get_settings();
        }
        
        $form_data = array();
        $form_data['id'] = $form_id;
        $form_data['settings'] = $form->get_settings();
        $form_data['fields'] = $fields_settings;
        $form_data['actions'] = $actions_settings;

        ?>
        <script>
            var preloadedFormData = <?php echo wp_json_encode( $form_data ); ?>;
            // console.log( preloadedFormData );
        </script>
        <?php
    }

    private function _localize_field_type_data()
    {
        $field_type_settings = array();

        $master_settings_list = array();

        $setting_defaults = array();

        foreach( Ninja_Forms()->fields as $field ){

            $name = $field->get_name();

            $settings = $field->get_settings();

            $settings_groups = Ninja_Forms::config( 'SettingsGroups' );

            $settings_defaults = array();

            foreach( $settings as $setting ){

                $group = $setting[ 'group' ];
                $settings_groups[ $group ][ 'settings' ][] = $setting;

                if( isset( $setting[ 'name' ] ) ){

                    if( isset( $setting[ 'type' ] ) && 'fieldset' == $setting[ 'type' ] ){

                        foreach( $setting[ 'settings' ] as $fieldset_setting ){

                            $setting_name = $fieldset_setting[ 'name' ];
                            $master_settings_list[] = $fieldset_setting;

                            if( isset( $setting[ 'value' ] ) ) {
                                $settings_defaults[$setting_name] = $setting['value'];
                            }
                        }
                    } else {
                        $setting_name = $setting[ 'name' ];
                        $master_settings_list[] = $setting;

                        if( isset( $setting[ 'value' ] ) ) {
                            $settings_defaults[$setting_name] = $setting['value'];
                        }
                    }
                }
            }

            foreach( $settings_groups as $id => $group ) {
                if ( empty( $group[ 'settings' ] ) ) {
                    unset( $settings_groups[ $id ] );
                }
            }

            $field_type_settings[ $name ] = array(
                'id' =>  $name,
                'nicename' => $field->get_nicename(),
                'alias' => $field->get_aliases(),
                'parentType' => $field->get_parent_type(),
                'section' => $field->get_section(),
                'type' => $field->get_type(),
                'settingGroups' => $settings_groups,
                'settingDefaults' => $settings_defaults
            );
        }
        ?>
        <script>
            var fieldTypeData = <?php echo wp_json_encode( $field_type_settings ); ?>;
            var fieldSettings = <?php echo wp_json_encode( $master_settings_list ); ?>;
            // console.log( fieldTypeData );
        </script>
        <?php
    }

    private function _localize_action_type_data()
    {
        $action_type_settings = array();

        foreach( Ninja_Forms()->actions as $action ){

            $name = $action->get_name();

            $settings = $action->get_settings();

            $action_type_settings[ $name ] = $settings;
        }
        ?>
        <script>
            var actionTypeData = <?php echo wp_json_encode( $action_type_settings ); ?>;
            // console.log( actionTypeData );
        </script>
        <?php
    }

}
