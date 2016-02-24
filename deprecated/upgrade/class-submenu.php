<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_THREE_Submenu
{
    /**
     * (required) The slug name for the parent menu (or the file name of a standard WordPress admin page)
     *
     * @var string
     */
    public $parent_slug = 'ninja-forms';

    /**
     * (required) The text to be displayed in the title tags of the page when the menu is selected
     *
     * @var string
     */
    public $page_title = 'Ninja Forms THREE';

    /**
     * (required) The on-screen name text for the menu
     *
     * @var string
     */
    public $menu_title = 'Ninja Forms THREE';

    /**
     * (required) The capability required for this menu to be displayed to the user.
     *
     * @var string
     */
    public $capability = 'manage_options';

    /**
     * (required) The slug name to refer to this menu by (should be unique for this menu).
     *
     * @var string
     */
    public $menu_slug = 'ninja-forms-three';

    /**
     * (optional) The function that displays the page content for the menu page.
     *
     * @var string
     */
    public $function = 'display';

    public $priority = 9001;

    /**
     * Constructor
     *
     * Translate text and add the 'admin_menu' action.
     */
    public function __construct()
    {
        $this->menu_title = __( 'Upgrade', 'ninja-forms' );
        $this->page_title = __( 'Upgrade to Ninja Forms THREE', 'ninja-forms' );

        $this->capability = add_filter( 'submenu_' . $this->menu_slug . '_capability', $this->capability );

        add_action( 'admin_menu', array( $this, 'register' ), $this->priority );

        add_action( 'wp_ajax_ninja_forms_upgrade_check', 'upgrade_check' );
    }

    /**
     * Register the menu page.
     */
    public function register()
    {
        $function = ( $this->function ) ? array( $this, $this->function ) : NULL;

        add_submenu_page(
            $this->parent_slug,
            $this->page_title,
            $this->menu_title,
            $this->capability,
            $this->menu_slug,
            $function
        );
    }

    /**
     * Display the menu page.
     */
    public function display(){

        $all_forms = Ninja_Forms()->forms()->get_all();

        $forms = array();
        foreach( $all_forms as $form_id ){

            $can_upgrade = TRUE;

            $fields = Ninja_Forms()->form( $form_id )->fields;
            $settings = Ninja_Forms()->form( $form_id )->get_all_settings();

            foreach( $fields as $field ){
                if( '_calc' == $field[ 'type' ] ){
                    $can_upgrade = FALSE;
                }
            }

            $forms[ $form_id ] = array(
                'form_title' => $settings[ 'form_title' ],
                'can_upgrade' => $can_upgrade
            );
        }

        include plugin_dir_path( __FILE__ ) . 'tmpl-submenu.html.php';
    }

    public function upgrade_check(){

        $response = array();

        echo wp_json_encode( $response );

        wp_die(); // this is required to terminate immediately and return a proper response
    }

}

new NF_THREE_Submenu();