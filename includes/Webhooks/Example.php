<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Webhooks_Example extends NF_Webhooks_Webhook
{
    protected $action = 'example';

    public function process( $payload )
    {
        $this->respond( 'success' );
    }
}