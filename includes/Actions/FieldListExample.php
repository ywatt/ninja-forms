<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Action_Custom
 */
final class NF_Actions_FieldListExample extends NF_Abstracts_Action
{
    /**
     * @var string
     */
    protected $_name  = 'field-list-example';

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
    protected $_priority = 10;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Field List Example', 'ninja-forms' );

        $settings = array(
            'field_list' => array(
                'name' => 'field_list',
                'type' => 'field-list',
                'label' => __( 'Field List', 'ninja-forms' ),
                'width' => 'full',
                'group' => 'primary',
                'field_types' => array( 'textbox' ),
//                'field_filter' => array(
//                    'terms' => array(
//                        'taxonomy' => $this->taxonomy_name
//                    ),
//                ),
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
