<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WordPress Menu Page Base Class
 */
abstract class NF_Admin_Submenu
{
    /**
     * (required) The slug name for the parent menu (or the file name of a standard WordPress admin page)
     *
     * @var string
     */
    public $parent_slug = '';

    /**
     * (required) The text to be displayed in the title tags of the page when the menu is selected
     *
     * @var string
     */
    public $page_title = '';

    /**
     * (required) The on-screen name text for the menu
     *
     * @var string
     */
    public $menu_title = '';

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
    public $menu_slug = '';

    /**
     * (optional) The function that displays the page content for the menu page.
     *
     * @var string
     */
    public $function = 'display';

    /**
     * Constructor
     *
     * Translate text and add the 'admin_menu' action.
     */
    public function __construct()
    {
        if( ! $this->menu_title ) {
            $this->menu_title = $this->page_title;
        }

        if( ! $this->menu_slug ) {
            $this->menu_slug = strtolower( preg_replace( '/[^A-Za-z0-9-]+/', '-', $this->menu_title ) );
        }

        $this->capability = add_filter( 'submenu_' . $this->menu_slug . '_capability', $this->capability );

        add_action( 'admin_menu', array( $this, 'register' ) );
    }

    /**
     * Register the menu page.
     */
    public function register()
    {
        add_submenu_page(
            $this->parent_slug,
            $this->page_title,
            $this->menu_title,
            $this->capability,
            $this->menu_slug,
            array( $this, $this->function )
        );
    }

    /**
     * Display the menu page.
     */
    public abstract function display();


}