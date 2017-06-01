<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Webhooks_Example implements NF_Webhooks_Webhook
{
    public function process( $payload, $response )
    {
        $response->respond( 'success' );
    }
}
