<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Action_Custom
 */
final class NF_Actions_Custom extends NF_Abstracts_Action
{
    /**
     * @var string
     */
    protected $_name  = 'custom';

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

        $settings = Ninja_Forms::config( 'ActionCustomSettings' );

        $this->_settings = array_merge( $this->_settings, $settings );
    }

    /*
    * PUBLIC METHODS
    */

    public function save()
    {

    }

    public function process( $action_settings, $form_id, $data )
    {
        ob_start(); // Use the Output Buffer to suppress output

        switch( $action_settings['hook'] ){
            case 'action':
                do_action( $action_settings['tag'], $data );
                break;
            case 'filter':
                $data = apply_filters( $action_settings['tag'], $data );
                break;
        }

        ob_end_clean();

        return $data;
    }
}
