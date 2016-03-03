<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_VersionSwitcher
{
    private $freemius;

    private $public_key = 'pk_a3fdd225c22bcc5b31224fc59ff3a';

    public function __construct()
    {
        $this->listener();
        add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 999 );

        // Init Freemius and override plugin's version.
        if ( ! has_filter( 'fs_plugin_version_ninja-forms' ) ) {
            add_filter( 'fs_plugin_version_ninja-forms', 'nf_plugin_version' );
        }
    }

    public function listener()
    {
        if( isset( $_GET[ 'nf-switcher' ] ) ){

            switch( $_GET[ 'nf-switcher' ] ){
                case 'upgrade':
                    add_action( 'plugins_loaded', array( $this, 'upgrade' ) );
                    update_option( 'ninja_forms_load_deprecated', FALSE );
                    break;
                case 'rollback':
                    add_action( 'plugins_loaded', array( $this, 'downgrade' ) );
                    update_option( 'ninja_forms_load_deprecated', TRUE );
                    break;
            }
        }
    }

    public function admin_bar_menu( $wp_admin_bar )
    {
        $args = array(
            'id'    => 'nf',
            'title' => 'Ninja Forms',
            'href'  => '#',
        );
        $wp_admin_bar->add_node( $args );
        $args = array(
            'id' => 'nf_switcher',
            'href' => admin_url(),
            'parent' => 'nf'
        );
        if( ! get_option( 'ninja_forms_load_deprecated' ) ) {
            $args[ 'title' ] = 'Rollback to 2.9.x';
            $args[ 'href' ] .= '?nf-switcher=rollback';
        } else {
            $args[ 'title' ] = 'Upgrade to 3.0.x';
            $args[ 'href' ] .= '?nf-switcher=upgrade';
        }
        $wp_admin_bar->add_node($args);
    }

    public function freemius()
    {
        if( ! $this->freemius ){

            require_once dirname( __FILE__ ) . '/freemius/start.php';

            $this->freemius = fs_dynamic_init( array(
                'id'                => '212',
                'slug'              => 'ninja-forms',
                'public_key'        => $this->public_key,
                'is_live'           => false,
                'is_premium'        => false,
                'has_addons'        => false,
                'has_paid_plans'    => false,
                'menu'              => array(
                    'slug'       => 'ninja-forms',
                    'account'    => false,
                    'support'    => false,
                ),
            ) );
        }

        return $this->freemius;
    }

    public function upgrade()
    {
        update_option( 'ninja_forms_version', '3.0' );
        // Turn Freemius on.
        update_option( 'ninja_forms_freemius', 1 );

        nf_override_plugin_version();

        if ( ! $this->freemius()->is_registered() && $this->freemius()->has_api_connectivity() ) {
            if ( $this->freemius()->opt_in() ) {
                // Successful opt-in into Freemius.
            }
        } else if ( $this->freemius()->is_registered() ) {
            // Send immediate re-upgrade event.
            $this->freemius()->_run_sync_install();
        }
    }


    public function downgrade()
    {
        update_option( 'ninja_forms_version', '2.9' );

        if ( $this->freemius()->is_registered() ) {
            // Send immediate downgrade event.
            $this->freemius()->_run_sync_install();
        }
    }

    public function opt_out()
    {
        $this->freemius()->delete_account_event();

        // Turn Freemius off.
        update_option( 'ninja_forms_freemius', 0 );
    }
}