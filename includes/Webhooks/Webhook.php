<?php if ( ! defined( 'ABSPATH' ) ) exit;

interface NF_Webhooks_Webhook
{
    public function process( $payload, $response );
}
