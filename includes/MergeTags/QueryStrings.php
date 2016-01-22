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
            'querystringexample' => array(
                'id' => 'querystringexample',
                'tag' => '{query_string_key}',
                'label' => __( 'Query String', 'ninja_forms' ),
            ),
        );

        if( is_admin() ) return;

        if( ! is_array( $_GET ) ) return;

        foreach( $_GET as $key => $value ){
            $this->set_merge_tags( $key, htmlspecialchars( $value, ENT_QUOTES ) );
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
            'tag' => "{" . $key . "}",
            'callback' => $callback,
            'value' => $value
        );
    }

} // END CLASS NF_MergeTags_Fields
