<?php

final class NF_VersionSwitcher
{
    public function __construct()
    {
        $this->listener();

        if( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            add_action('admin_bar_menu', array($this, 'admin_bar_menu'), 999);
        }
    }

    public function listener()
    {
        if( isset( $_GET[ 'nf-switcher' ] ) ){

            switch( $_GET[ 'nf-switcher' ] ){
                case 'upgrade':
                    update_option( 'ninja_forms_load_deprecated', FALSE );
                    nf_fs_upgrade();
                    break;
                case 'rollback':
                    update_option( 'ninja_forms_load_deprecated', TRUE );
                    nf_fs_downgrade();
                    break;
            }

            header( 'Location: ' . admin_url( 'admin.php?page=ninja-forms' ) );
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

}

new NF_VersionSwitcher();

/*
|--------------------------------------------------------------------------
| Freemius Integration
|--------------------------------------------------------------------------
*/

function fs_ninja_add_settings_page() {
    $hook = add_menu_page(
        'Settings',
        'Ninja Upgrade',
        'manage_options',
        'fs-manual-optin',
        'fs_ninja_render_settings_page'
    );
}

function fs_ninja_render_settings_page() {
    ninja_forms_actions();

    ?>
    <h1>Manual Opt-in</h1>
    <h3>Current version: <?php echo nf_plugin_version( '' ) ?></h3>
    <?php if ( '2.9' === nf_plugin_version( '' ) ) : ?>
        <form action="" method="post">
            <input type="hidden" name="ninja_action" value="upgrade">
            <button class="button button-primary">Upgrade Ninja Forms</button>
        </form>
    <?php else : ?>
        <form action="" method="post">
            <input type="hidden" name="ninja_action" value="downgrade">
            <button class="button">Downgrade Ninja Forms</button>
        </form>
    <?php endif ?>
    <?php if ( nf_is_freemius_on() && nf_fs()->is_registered() ) : ?>
        <br>
        <form action="" method="post">
            <input type="hidden" name="ninja_action" value="opt_out">
            <button class="button">Opt-out from Freemius</button>
        </form>
    <?php endif ?>
    <?php
}

add_action( 'admin_menu', 'fs_ninja_add_settings_page' );

function nf_plugin_version( $version ) {
    return get_option( 'ninja_forms_version', '2.9' );
}

// Create a helper function for easy SDK access.
function nf_fs() {
    global $nf_fs;

    if ( ! isset( $nf_fs ) ) {
        // Include Freemius SDK.
        require_once dirname( __FILE__ ) . '/freemius/start.php';

        $nf_fs = fs_dynamic_init( array(
            'slug'           => 'ninja-forms',
            'id'             => '219',
            'public_key'     => 'pk_c15496cc04a1d46d3f18389dc3a4b',
            'is_premium'     => false,
            'has_addons'     => false,
            'has_paid_plans' => false,
            'menu'           => array(
                'slug'    => 'ninja-forms',
                'account' => false,
                'support' => false,
                'contact' => false,
            ),
        ) );
    }

    return $nf_fs;
}

function nf_is_freemius_on() {
    return get_option( 'ninja_forms_freemius', 0 );
}

function nf_override_plugin_version() {
    // Init Freemius and override plugin's version.
    if ( ! has_filter( 'fs_plugin_version_ninja-forms' ) ) {
        add_filter( 'fs_plugin_version_ninja-forms', 'nf_plugin_version' );
    }
}

if ( nf_is_freemius_on() ) {
    // Override plugin's version, should be executed before Freemius init.
    nf_override_plugin_version();

    // Init Freemius.
    nf_fs();
}

function ninja_forms_actions() {
    if ( empty( $_POST['ninja_action'] ) || ! in_array( $_POST['ninja_action'], array(
            'upgrade',
            'downgrade',
            'opt_out'
        ) )
    ) {
        return;
    }

    switch ( $_POST['ninja_action'] ) {
        case 'upgrade':
            nf_fs_upgrade();
            break;
        case 'downgrade':
            nf_fs_downgrade();
            break;
        case 'opt_out':
            nf_fs_optout();
            break;
    }
}

function nf_fs_upgrade(){
    update_option( 'ninja_forms_version', '3.0' );
    // Turn Freemius on.
    update_option( 'ninja_forms_freemius', 1 );

    nf_override_plugin_version();

    if ( ! nf_fs()->is_registered() && nf_fs()->has_api_connectivity() ) {
        if ( nf_fs()->opt_in() ) {
            // Successful opt-in into Freemius.
        }
    } else if ( nf_fs()->is_registered() ) {
        // Send immediate re-upgrade event.
        nf_fs()->_run_sync_install();
    }
}

function nf_fs_downgrade(){
    update_option( 'ninja_forms_version', '2.9' );
    if ( nf_fs()->is_registered() ) {
        // Send immediate downgrade event.
        nf_fs()->_run_sync_install();
    }
}

function nf_fs_optout(){
    nf_fs()->delete_account_event();
    // Turn Freemius off.
    update_option( 'ninja_forms_freemius', 0 );
}