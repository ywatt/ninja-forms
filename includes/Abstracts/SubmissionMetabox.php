<?php if ( ! defined( 'ABSPATH' ) ) exit;

abstract class NF_Abstracts_SubmissionMetabox
{
    protected $_id = '';

    protected $_title = '';

    protected $_callback = 'render_metabox';

    protected $_post_types = array( 'nf_sub', 'nf_subs' );

    protected $_context = 'side';

    protected $_priority = 'default';

    protected $_callback_args = array();

    public function __construct()
    {
        $this->_id = 'nf_sub_metabox_' . strtolower( __CLASS__ );
        $this->_title = __( 'Example Metabox' );

        $post_id = absint( $_GET[ 'post' ] );

        $this->_callback_args[ 'sub' ] = Ninja_Forms()->form()->get_sub( $post_id );
        
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
    }

    public function add_meta_boxes()
    {
        add_meta_box(
            $this->_id,
            $this->_title,
            array( $this, $this->_callback ),
            $this->_post_types,
            $this->_context,
            $this->_priority,
            $this->_callback_args
        );
    }

    abstract public function render_metabox( $post, $metabox );

    protected function get_field_values()
    {
        return $this->_callback_args[ 'sub' ]->get_field_values();
    }
}