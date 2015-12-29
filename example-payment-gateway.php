<?php

class NF_PaymentGateway_Example extends NF_Abstracts_PaymentGateway
{
    protected $slug = 'example';

    protected $name = 'Example Gateway';

    public function __construct()
    {
        parent::__construct();

        $this->_settings = array(
            'example_payment_setting' => array(
                'name' => 'example_payment_setting',
                'type' => 'textbox',
                'label' => __( 'Example Payment Setting', 'ninja-forms' ),
                'value' => '',
                'width' => 'full',
                'group' => 'primary',
                'deps' => array(
                    'payment_gateways' => $this->slug
                )
            ),
        );
    }

    protected function process( $action_settings, $form_id, $data )
    {
        return $data;
    }
}

new NF_PaymentGateway_Example();