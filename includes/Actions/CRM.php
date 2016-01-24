<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Action_CRM
 */
final class NF_Actions_CRM extends NF_Abstracts_Action
{
    /**
     * @var string
     */
    protected $_name  = 'crm';

    /**
     * @var array
     */
    protected $_tags = array();

    /**
     * @var string
     */
    protected $_timing = 'normal';

    /**
     * @var int
     */
    protected $_priority = '10';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'CRM', 'ninja-forms' );

        $settings = array(
            'duplicate_check' => array(
                'name' => 'duplicate_check',
                'type' => 'toggle',
                'label' => __( 'Check for duplicates and suggest a merge in Insightly?', 'ninja-forms' ),
                'width' => 'full',
                'group' => 'primary',
                'value' => FALSE,
                'help' => __( 'Do you want to check for duplicates?', 'ninja-forms' ),
            ),
            'field_maps' => array(
                'name' => 'field_maps',
                'type' => 'option-repeater',
                'label' => ' <a href="#" class="nf-add-new">' . __( 'Add New Field Map', 'ninja-forms' ) . '</a>',
                'width' => 'full',
                'group' => 'primary',
                'tmpl_row' => 'nf-tmpl-edit-crm-field-map-repeater-row',
                'use_merge_tags' => array(
                    'exclude' => array(
                        'user', 'system', 'post', 'querystrings'
                    ),
                ),
                'columns' => array(
                    'form_field' => array(
                        'header' => __( 'Form Field', 'ninja-forms' ),
                        'default' => 'Smith',
                    ),
                    'crm_field' => array(
                        'header' => __( 'CRM Field', 'ninja-forms' ),
                        'default' => 2,
                        'options' => array(
                            array(
                                'value' => 1,
                                'label' => 'One'
                            ),
                            array(
                                'value' => 2,
                                'label' => 'Two'
                            )
                        )
                    ),
                ),
            ),
        );

        $this->_settings = array_merge( $this->_settings, $settings );
    }

    /*
    * PUBLIC METHODS
    */

    public function save( $action_settings )
    {

    }

    public function process( $action_settings, $form_id, $data )
    {
        return $data;
    }
}
