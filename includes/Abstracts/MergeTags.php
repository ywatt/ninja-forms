<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_MergeTags
 */
abstract class NF_Abstracts_MergeTags
{
    protected $merge_tags = array();

    public function __construct()
    {
        add_filter( 'ninja_forms_render_default_value', array( $this, 'replace' ) );
    }

    public function replace( $subject )
    {
        foreach( $this->merge_tags as $merge_tag ){

            if( FALSE !== strpos( $subject, $merge_tag[ 'tag' ] ) ){

                $replace = ( method_exists( $this, $merge_tag[ 'callback' ] ) ) ? $this->{$merge_tag[ 'callback' ]}() : '';

                $subject = str_replace( $merge_tag[ 'tag' ], $replace, $subject );
            }
        }

        return $subject;
    }


} // END CLASS NF_Abstracts_MergeTags
