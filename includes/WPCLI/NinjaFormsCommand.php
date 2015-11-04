<?php if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'WP_CLI_Command' ) ) exit;

class NF_WPCLI_NinjaFormsCommand extends WP_CLI_Command
{
    /**
     * Help Subcommand
     *
     * @subcommand help
     */
    function help()
    {
        $this->peeking_ninja();
        WP_CLI::success( 'Welcome to the Ninja Forms WP-CLI Extension!' );
        WP_CLI::line( '' );
        WP_CLI::line( '- Ninja Forms Version: ' . Ninja_Forms::VERSION );
        WP_CLI::line( '- Ninja Forms Directory: ' . Ninja_Forms::$dir );
        WP_CLI::line( '- Ninja Forms Public URL: ' . Ninja_Forms::$url );
        WP_CLI::line( '' );
    }

    private function peeking_ninja()
    {
        $output = file_get_contents( Ninja_Forms::$dir . 'includes/Templates/wpcli-header-art.txt' );
        WP_CLI::line( $output );
    }

} // END CLASS NF_WPCLI_NinjaFormsCommand
