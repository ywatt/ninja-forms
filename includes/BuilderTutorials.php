<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_BuilderTutorials
 */
final class NF_BuilderTutorials
{
    private $tutorials = array();
    private $rss_feeds;

    public function __construct()
    {
        add_action( 'admin_init',    array( $this, 'register_tutorials' ) );
        add_action( 'rest_api_init', array( $this, 'register_routes'    ) );

        $this->tutorials[ 'example'] = array(
            'id' => 'example',
            'title' => 'Example',
            'video_url' => 'https://www.youtube.com/embed/RySHDUU2juM',
            'description' => '<h2>' . __( 'This is an example', 'ninja-forms' ) . '</h2><p>TEST THIS OUT!</p>',
            'trigger' => 'render:builder',
            'priority' => 10
        );
    }

    public function get_tutorials( WP_REST_Request $request )
    {
        /*
         * Loop over our tutorials and make sure that they should be displayed.
         * If they shouldn't, then we unset the trigger.
         * TODO: Allow the tutorials to be opened later via a menu.
         */
        $show_tutorials = get_option( 'nf_show_tutorials', false );
        $closed_tutorials = get_user_option( 'nf_closed_tutorials', array() );
        
        // update_user_option( get_current_user_id(), 'nf_closed_tutorials', array( 'example' ) );

        foreach( $this->tutorials as &$tutorial ) {
            /*
             * If we don't want to auto-play any tutorials, then we need to unset the trigger for each.
             */
            if ( ! $show_tutorials || in_array( $tutorial[ 'id' ], $closed_tutorials ) ) {
              $tutorial[ 'trigger' ] = '';
            }
            
        }

        return array_values( $this->tutorials );
    }

    public function update_user_option( $data ) {
        var_dump( $data );
        die( 'fuck it' );
    }

    public function fetch_feeds()
    {

    }

    /*
    |--------------------------------------------------------------------------
    | FILTER HOOKS
    |--------------------------------------------------------------------------
    */

    public function register_tutorials()
    {
        $this->tutorials = apply_filters( 'ninja_forms_register_tutorials',      $this->tutorials );
        $this->rss_feeds = apply_filters( 'ninja_forms_register_tutorial_feeds', $this->rss_feeds );
    }

    /*
    |--------------------------------------------------------------------------
    | REST ENDPOINTS
    |--------------------------------------------------------------------------
    */

    public function register_routes()
    {
        register_rest_route( 'ninja-forms/v1', '/tutorials', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_tutorials' )
        ) );
        register_rest_route( 'ninja-forms/v1', '/tutorials', array(
            'methods' => 'POST',
            'callback' => array( $this, 'update_user_option' )
        ) );
    }
}