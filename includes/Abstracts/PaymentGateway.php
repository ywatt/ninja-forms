<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_PaymentGateway
 */
abstract class NF_Abstracts_PaymentGateway
{
    protected $slug = '';

    protected $name = '';

    public function __construct()
    {
        add_filter( 'ninja_forms_collect_payment_process', array( $this, '_process' ) );
        add_filter( 'ninja_forms_payment_gateways', array( $this, 'add_payment_gateway' ) );
        add_filter( 'ninja_forms_payment_gateway_settings', array( $this, 'add_collect_payment_settings' ) );
    }

    public function _process( $action_settings, $form_id, $data )
    {
        if( $this->slug == $action_settings[ 'payment_gateway' ] ){
            return $this->process( $action_settings, $form_id, $data );
        }
    }

    abstract protected function process( $action_settings, $form_id, $data );

    public function add_payment_gateway( $payment_gateways )
    {
        $payment_gateways[] = array(
            'label' => $this->name,
            'value' => $this->slug,
        );

        return $payment_gateways;
    }

    public function add_collect_payment_settings( $settings )
    {


        $settings = array_merge( $settings, $this->_settings );
        return $settings;
    }
}
