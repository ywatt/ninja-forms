<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Webhooks_PluginInstall extends NF_Webhooks_Webhook
{
    protected $action = 'install';

    public function process( $payload )
    {
        $this->respond( 'false' );
    }
}