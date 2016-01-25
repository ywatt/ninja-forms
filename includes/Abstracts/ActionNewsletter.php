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

    protected $_settings = array( 'field_map' );

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
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

    protected function add_map_field( $field )
    {
        $this->_settings[ 'field_map' ][ 'columns' ][ 'map_field' ][ 'options' ][] = array(
            'value' => $field[ 'value' ],
            'label' => $field[ 'label' ]
        );
    }

    protected function add_map_fields( $fields )
    {
        if( ! is_array( $fields ) ) return;

        foreach( $fields as $field ){
            $this->add_map_field( $field );
        }
    }

}
