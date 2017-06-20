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
        // TODO: Get download, license, api_url from payload
        $api_url = 'https://my.ninjaforms.com';
        extract($this->payload);
        
        $this->_install_plugin( $download, $license, $api_url );
        if( $this->is_plugin_installed( $download ) ){
            $this->response->respond( 'success' );   
        } else {
            $this->response->respond( 'failure' );
        }
    }
    

    private function _register_license( $license ) {
        
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
    private function _install_plugin( $download, $license, $api_url ) {

      $api_args = array(
        'edd_action' => 'get_download',
        'item_name'  => urlencode( $download ),
        'license'    => $license,
        'url'        => home_url(),
        'expires'    => rawurlencode( base64_encode( strtotime( '+10 minutes' ) ) ),
      );

      $download_link = add_query_arg( $api_args, $api_url );

      error_log( 'LINK: ' . print_r( $download_link, true ) );

      if ( ! class_exists( 'Plugin_Upgrader' ) ) {
        include_once ABSPATH . 'wp-admin/includes/file.php';
        include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
      }

        ob_start();
      $upgrader = new Plugin_Upgrader( $skin = new Plugin_Installer_Skin(
        compact( 'type', 'title', 'url', 'nonce', 'plugin', 'api' ) ));

      $upgrader->install( $download_link );
        ob_clean();
    }
    
    /**
	 * Checks if plugin is installed
	 *
	 * @param string $plugin_name
	 *
	 * @return bool
	 */
	public function is_plugin_installed( $plugin_name ) {
		$return = false;
		if ( empty( $plugin_name ) ) {
			return $return;
		}
		foreach ( get_plugins() as $plugin ) {
            var_dump($plugin);
			if ( $plugin[ 'Name' ] === $plugin_name ) {
				$return = true;
				break;
			}
		}
		return $return;
    }

}