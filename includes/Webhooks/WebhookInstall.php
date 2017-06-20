<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Webhooks_WebhookInstall implements NF_Webhooks_Webhook
{
    public $payload = '';
    public $response = '';

    public function process( $payload, $response )
    {
        $this->payload = $payload;
        $this->response = $response;
        add_action('init', array($this, 'init'), 10);
    }

    public function init ( )
    {
        if( ! isset( $this->payload[ 'download' ] ) || ! isset( $this->payload[ 'license' ] ) ) {
            $this->response->respond( array(
                'error' => 'Resource Not Found'
            ), 404 );
        };

        // @todo Check if already installed.

        $result = $this->_install_plugin( $this->payload[ 'download' ], $this->payload[ 'license' ], 'https://my.ninjaforms.com' );

        // @todo Check for errors.
        $this->response->respond( $result );
    }

    /**
    * Literally installs the plugin
    *
    * @param string $download Download slug.
    * @param string $license Valid license key.
    * @param string $api_url Download URL.
    *
    * @return bool
    */
    private function _install_plugin( $download, $license, $api_url )
    {
        $api_args = array(
            'edd_action' => 'get_download',
            'item_name'  => urlencode( $download ),
            'license'    => $license,
            'url'        => urlencode( home_url() ),
            'expires'    => rawurlencode( base64_encode( strtotime( '+10 minutes' ) ) ),
        );

        $download_link = add_query_arg( $api_args, $api_url );

        if ( ! class_exists( 'Plugin_Upgrader' ) ) {
            include_once ABSPATH . 'wp-admin/includes/file.php';
            include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        }

        $skin = new NF_Libraries_RemoteInstaller_PluginInstallerSkin();
        $upgrader = new Plugin_Upgrader( $skin );
        $upgrader->install( $download_link );
        
        return $upgrader->result;
    }
}
