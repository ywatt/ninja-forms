<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_MergeTags_Other
 */
final class NF_MergeTags_Other extends NF_Abstracts_MergeTags
{
    protected $id = 'other';

    public function __construct()
    {
        parent::__construct();
        $this->title = __( 'Other', 'ninja-forms' );

        $this->merge_tags = array(
            '' => array(
                'tag' => '{query_string_key}',
                'label' => __( 'Query String', 'ninja_forms' ),
                'callback' => null,
            ),
        );

        if( is_admin() ) return;

        if( ! is_array( $_GET ) ) return;

        foreach( $_GET as $key => $value ){
            $value = WPN_Helper::get_query_string( $key );
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
            'tag' => "{" . $key . "}",
            'callback' => $callback,
            'value' => $value
        );
    }

} // END CLASS NF_MergeTags_Other
