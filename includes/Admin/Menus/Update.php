<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_Update extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'Update';

    public $priority = 11;

    protected $_prefix = 'ninja_forms';

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        echo "<h1>Update Ninja Forms</h1>";

        $migrations = new NF_Database_Migrations();
        $migrations->nuke(TRUE, TRUE);
        $migrations->migrate();

        $forms = $this->get_forms();

        foreach( $forms as $old_form ){

            $form = Ninja_Forms()->form()->get();
            $form->update_setting( 'title', $old_form[ 'settings' ][ 'form_title' ] );

            foreach( $old_form[ 'settings' ] as $key => $value ){

                if( in_array( $key, array( 'form_title', 'ajax' ) ) ) continue;

                switch( $key ){
                    case 'hide_complete':
                        $key = 'hide_successfully_completed_form';
                        break;
                    case 'show_title':
                        $key = 'display_form_title';
                        break;
                    case 'clear_complete':
                        $key = 'clear_successfully_created_form';
                        break;
                }

                $form->update_setting( $key, $value );

            }

            $form->save();
        }
    }

    private function get_forms()
    {
        global $wpdb;

        $results = $wpdb->get_results(
            "
            SELECT id
            FROM `{$wpdb->prefix}nf_objects`
            WHERE type = 'form'
            "
        );

        $forms = array();
        foreach( $results as $result ){
            $forms[ $result->id ] = array(
                'id' => $result->id,
                'settings' => $this->get_form_settings( $result->id )
            );
        }
        return $forms;
    }

    private function get_form_settings( $form_id )
    {
        global $wpdb;

        $results = $wpdb->get_results(
            "
            SELECT meta_key, meta_value
            FROM `{$wpdb->prefix}nf_objectmeta`
            WHERE object_id = $form_id
            "
        );

        $settings = array();
        foreach( $results as $result ){
            $settings[ $result->meta_key ] = $result->meta_value;
        }
        return $settings;
    }


} // End Class NF_Admin_Settings
