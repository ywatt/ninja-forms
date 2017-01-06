<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_BuilderTutorials
 */
final class NF_BuilderTutorials
{
    private $tutorials = array(
        'example' => array(
            'id' => 'example',
            'title' => 'Example',
            'content' => 'This is an example.'
        )
    );
    private $rss_feeds;

    public function __construct()
    {
        add_action( 'admin_init',    array( $this, 'register_tutorials' ) );
        add_action( 'rest_api_init', array( $this, 'register_routes'    ) );
    }

    public function get_tutorials( WP_REST_Request $request )
    {
        return $this->tutorials;
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
    }
}