<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_MergeTags_PostMeta
 */
final class NF_MergeTags_PostMeta extends NF_Abstracts_MergeTags
{
    protected $id = 'post_meta';

    /**
     * @var array
     * $post_meta[ $meta_key ] = $meta_value;
     */
    protected $post_meta = array();

    public function __construct()
    {
        parent::__construct();

        // Set a translatable, human-readable title for use in the builder.
        $this->title = __( 'Post Meta', 'ninja-forms' );

        $this->merge_tags = array(
            '' => array(
                'tag' => '{post_meta:}',
                'label' => __( 'Post Meta', 'ninja_forms' ),
                'callback' => null,
            ),
        );

        // Setup merge tag data for each post in The Loop.
        add_action( 'the_post', array( $this, 'init' ) );

        // Setup merge tag data when Doing AJAX.
        add_action( 'admin_init', array( $this, 'init' ) );
    }

    public function init()
    {
        global $post;

        /**
         * Determine the relevant Post ID based on context.
         * - Form Submission    ie Doing AJAX
         * - Form Display       ie The Post Loop
         */
        if ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            // If we are doing AJAX, use the referer to get the Post ID.
            $post_id = url_to_postid( wp_get_referer() );
        } elseif( $post ) {
            $post_id = $post->ID;
        } else {
            return; // No Post ID found.
        }

        $this->setup_post_meta( $post_id );
    }

    public function replace( $subject )
    {
        // Recursively replace merge tags.
        if( is_array( $subject ) ){
            foreach( $subject as $i => $s ){
                $subject[ $i ] = $this->replace( $s );
            }
            return $subject;
        }

        /**
         * {post_meta:foo} --> meta key is 'foo'
         */
        preg_match_all("/{post_meta:(.*?)}/", $subject, $matches );

        // If not matching merge tags are found, then return early.
        if( empty( $matches[0] ) ) return $subject;

        /**
         * $matches[0][$i]  merge tag match     {post_meta:foo}
         * $matches[1][$i]  captured meta key   foo
         */
        foreach( $matches[0] as $i => $search ){
            $meta_key = $matches[ 1 ][ $i ];
            if( ! isset( $this->post_meta[ $meta_key ] ) ) continue;
            $subject = str_replace( $search, $this->post_meta[ $meta_key ], $subject );
        }

        return $subject;
    }

    public function setup_post_meta( $post_id )
    {
        global $wpdb;

        // Get ALL post meta for a given Post ID.
        $results = $wpdb->get_results( $wpdb->prepare( "
            SELECT `meta_key`, `meta_value`
            FROM {$wpdb->postmeta}
            WHERE `post_id` = %d
        ", $post_id ) );

        foreach( $results as $result ){
            $this->post_meta[ $result->meta_key ] = $result->meta_value;
        }
    }
} // END CLASS NF_MergeTags_PostMeta
