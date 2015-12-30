<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Action_CollectPayment
 */
final class NF_Actions_CollectPayment extends NF_Abstracts_Action
{
    /**
     * @var string
     */
    protected $_name  = 'collectpayment';

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

        $this->_nicename = __( 'Collect Payment', 'ninja-forms' );

        $settings = Ninja_Forms::config( 'ActionCollectPaymentSettings' );

        $this->_settings = array_merge( $this->_settings, $settings );

        add_action( 'plugins_loaded', array( $this, 'filter_payment_gateways' ) );

        add_filter( 'ninja_forms_action_type_settings', array( $this, 'maybe_remove_action' ) );
    }

    /*
    * PUBLIC METHODS
    */

    public function save()
    {

    }

    public function process( $action_settings, $form_id, $data )
    {
        $data = apply_filter( 'ninja_forms_collect_payment_process', $action_settings, $form_id, $data );

        return $data;
    }

    public function filter_payment_gateways()
    {
        $payment_gateways = $this->_settings[ 'payment_gateways' ][ 'options' ];

        $this->_settings[ 'payment_gateways' ][ 'options' ] = apply_filters(
            'ninja_forms_payment_gateways',
            $payment_gateways
        );

        $this->_settings = apply_filters(
            'ninja_forms_payment_gateway_settings',
            $this->_settings
        );
    }

    public function maybe_remove_action( $action_type_settings )
    {
        if( count( $this->_settings[ 'payment_gateways' ][ 'options' ] ) == 1 ){
            unset( $action_type_settings[ $this->_name ] );
        }

        return $action_type_settings;
    }
}
