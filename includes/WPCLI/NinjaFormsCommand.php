<?php if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'WP_CLI_Command' ) ) exit;

class NF_WPCLI_NinjaFormsCommand extends WP_CLI_Command
{
    public function __construct()
    {
    }

    function __invoke()
    {
        WP_CLI::line( $this->peeking_ninja() );
        WP_CLI::line( 'Welcome to the Ninja Forms WP-CLI Extension!' );
        WP_CLI::line( '' );
        WP_CLI::line( '- Ninja Forms Version: ' . Ninja_Forms::VERSION );
    }

    /**
     * Status Command
     *
     * @param $args
     * @param $assoc_args
     */
    function status( $args, $assoc_args )
    {
        WP_CLI::line( 'Hello, world!' );
    }

    function error()
    {
        WP_CLI::error( 'It\'s A Trap!' );
    }

    function success()
    {
        WP_CLI::success( 'Fired a WP-CLI Command. Success.' );
    }

    private function peeking_ninja()
    {
        return file_get_contents( Ninja_Forms::$dir . 'includes/Templates/wpcli-header-art.txt' );
    }

} // END CLASS NF_WPCLI_NinjaFormsCommand
