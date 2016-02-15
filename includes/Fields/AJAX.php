<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Fields_AJAX extends NF_Fields_Textbox
{
    protected $_name = 'ajax';

    protected $_section = 'common';

    protected $_aliases = array( 'input' );

    protected $_type = 'ajax';

    protected $_templates = 'textbox';

    protected $_test_value = 'Lorem ipsum';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'AJAX Test', 'ninja-forms' );

        $this->_settings[ 'ajax_textbox' ] = array(
            'name' => 'ajax_textbox',
            'type' => 'textbox',
            'label' => __( 'AJAX Test', 'ninja-forms'),
            'width' => 'one-half',
            'group' => 'primary',
            'value' => '',
            'ajax' => array(
                'listen' => 'label',
                'action' => 'kbj_ajax'
            )
        );

        $this->_settings[ 'ajax_select' ] = array(
            'name' => 'ajax_select',
            'type' => 'select',
            'label' => __( 'AJAX Select', 'ninja-forms'),
            'width' => 'one-half',
            'group' => 'primary',
            'value' => '',
            'options' => array(
                array(
                    'label' => 'Aye',
                    'value' => 'a'
                ),
                array(
                    'label' => 'Bee',
                    'value' => 'b'
                )
            ),
            'ajax' => array(
                'listen' => 'label',
                'action' => 'kbj_ajax'
            )
        );

        add_action( 'wp_ajax_kbj_ajax',   array( $this, 'ajax' )   );
    }

    public function ajax() {
        $response = array(
            'parent' => $_POST[ 'parentValue' ],
            'value' => time(),
            'options' => array(
                array(
                    'label' => 'One',
                    'value' => 1
                ),
                array(
                    'label' => 'Two',
                    'value' => 2
                )
            )
        );
        echo wp_json_encode( $response );

        wp_die(); // this is required to terminate immediately and return a proper response
    }
}
