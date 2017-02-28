<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_MergeTags_QueryStrings
 */
final class NF_MergeTags_QueryStrings extends NF_Abstracts_MergeTags
{
    protected $id = 'querystrings';

    public function __construct()
    {
        parent::__construct();
        $this->title = __( 'Query Strings', 'ninja-forms' );

        $this->merge_tags = array(
            '' => array(
                'tag' => '{query_string_key}',
                'label' => __( 'Query String', 'ninja_forms' ),
                'callback' => null,
            ),
        );

        add_action( 'init', array( $this, 'init' ) );
    }

    public function init()
    {
        if( is_admin() ) {
            if( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) return;
            $url_query = parse_url( wp_get_referer(), PHP_URL_QUERY );
            parse_str( $url_query, $variables );
        } else {
            $variables = $_GET;
        }

        if( ! is_array( $variables ) ) return;

        foreach( $variables as $key => $value ){
            $value = wp_kses_post( $value );
            $this->set_merge_tags( $key, $value );
        }
    }

    public function __call($name, $arguments)
    {
        return $this->merge_tags[ $name ][ 'value' ];
    }

    public function set_merge_tags( $key, $value )
    {
        $callback = ( is_numeric( $key ) ) ? 'querystring_' . $key : $key;

        $this->merge_tags[ $callback ] = array(
            'id' => $key,
            'tag' => "{querystring:" . $key . "}",
            'callback' => $callback,
            'value' => $value
        );

        $this->merge_tags[ $callback . '_deprecated' ] = array(
            'id' => $key,
            'tag' => "{" . $key . "}",
            'callback' => $callback,
            'value' => $value
        );
    }

} // END CLASS NF_MergeTags_Fields
