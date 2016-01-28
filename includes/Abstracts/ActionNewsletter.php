<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_ActionNewsletter
 */
abstract class NF_Abstracts_ActionNewsletter extends NF_Abstracts_Action
{
    /**
     * @var array
     */
    protected $_tags = array( 'newsletter' );

    /**
     * @var string
     */
    protected $_timing = 'normal';

    /**
     * @var int
     */
    protected $_priority = '10';

    protected $_settings = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->get_list_settings();
    }

    /*
    * PUBLIC METHODS
    */

    public function save( $action_settings )
    {

    }

    public function process( $action_settings, $form_id, $data )
    {

    }

    private function get_list_settings()
    {
        $lists = $this->get_lists();

        if( empty( $lists ) ) return;

        $this->_settings[ 'newsletter_list' ] = array(
            'name' => 'newsletter_list',
            'type' => 'select',
            'label' => __( 'List', 'ninja-forms' ),
            'group' => 'primary',
            'value' => '2',
            'options' => array(),
        );

        $fields = array();
        foreach( $lists as $list ){
            $this->_settings[ 'newsletter_list' ][ 'options' ][] = $list;

            foreach( $list[ 'fields' ] as $field ){
                $name = $list[ 'value' ] . '_' . $field[ 'value' ];
                $fields[] = array(
                    'name' => $name,
                    'type' => 'textbox',
                    'label' => $field[ 'label' ],
                    'use_merge_tags' => array(
                        'exclude' => array(
                            'user', 'post', 'system', 'querystrings'
                        )
                    ),
                    'deps' => array(
                        'newsletter_list' => $list[ 'value' ]
                    )
                );
            }
        }

        $this->_settings[ 'newsletter_list_fieldset' ] = array(
            'name' => 'newsletter_list_fieldset',
            'label' => __( 'List Field Mapping', 'ninja-forms' ),
            'type' => 'fieldset',
            'group' => 'primary',
            'settings' => $fields
        );
    }
}
