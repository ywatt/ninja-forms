<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * NF_Notices Class
 *
 * Can be simply used be adding another line into the nf_admin_notices() function under notices.php
 *
 * Can be extended to create more advanced notices to include triggered events
 *
 * @since 2.9
 */

class NF_Notices
{
        // Highlander the instance
        static $instance;
        
        public static function instance()
        {
                if ( ! isset( self::$instance ) ) {
                        self::$instance = new NF_Notices();
                }

                return self::$instance;
        }

        public $notice_spam = 0;
        public $notice_spam_max = 5;

        // Basic actions to run
        public function __construct(){

                // Runs the admin notice ignore function incase a dismiss button has been clicked
                add_action( 'admin_init', array( $this, 'admin_notice_ignore' ) );
                
                // Runs the visibility checks for admin notices after all needed core files are loaded
                add_action( 'admin_head', array( $this, 'nf_admin_default_notices' ) );

        }
        
        // Default notices function
        // The hooked function is found in notices.php and that is where all basic notices can be created with a few simple lines.
        public function nf_admin_default_notices() {
                if ( $this->nf_admin_notice() ) {
                        add_action( 'admin_notices', 'nf_admin_notices' );
                }
        }
        
        // Checks to ensure notices aren't disabled, the user has the correct permissions, and the user is on the dashboard.
        public function nf_admin_notice() {

                $nf_settings = get_option( 'ninja_forms_settings' );
                if ( ! isset( $nf_settings[ 'disable_admin_notices' ] ) || ( isset( $nf_settings[ 'disable_admin_notices' ] ) && $nf_settings[ 'disable_admin_notices' ] == 0 ) ){
                        if ( current_user_can( apply_filters( 'ninja_forms_admin_parent_menu_capabilities', 'manage_options' ) ) && get_current_screen()->id === 'dashboard' ) {
                                return true;
                        }
                }
                return false;

        }
        
        // Primary notice function that can be called from an outside function sending necessary variables
        public function admin_notice( $message, $start_date = null, $interval = 14 ) {

                // Call for spam protection
                if ( $this->anti_notice_spam() ) {
                        return false;
                }

                // Get the current date then set start date to either passed value or current date value
                $current_date = date( "n/j/Y" );
                $start_date = ( $start_date != null ? $start_date : $current_date );
                $start_date = date( "n/j/Y", strtotime( $start_date ) );

                // This is the main notices storage option
                $admin_notices = ( get_option( 'nf_admin_notice' ) ? unserialize( get_option( 'nf_admin_notice' ) ) : array() );

                // Check if the message is already stored and if so just grab the key otherwise store the message and its associated date information
                foreach ($admin_notices as $key => $val) {
                        if ($val['message'] === $message) {
                            $message_number = $key;
                        }
                }
                
                if ( ! isset( $message_number ) ) {
                        $admin_notices[][ 'message' ] = $message;
                        end( $admin_notices );
                        $message_number = key( $admin_notices );
                        $admin_notices[ $message_number ][ 'start_date' ] = $start_date;
                        $admin_notices[ $message_number ][ 'interval' ] = $interval;
                        update_option( 'nf_admin_notice', serialize( $admin_notices ) );
                }

                // Sanity check to ensure we have accurate information
                // New date information will not overwrite old date information
                // Changing the message even by 1 character will create a new message and thus receive all new variables
                $admin_display_check = ( isset( $admin_notices[ $message_number ][ 'dismissed' ] ) ? $admin_notices[ $message_number ][ 'dismissed'] : 0 );
                $admin_display_start = ( isset( $admin_notices[ $message_number ][ 'start_date' ] ) ? $admin_notices[ $message_number ][ 'start_date'] : $start_date );
                $admin_display_interval = ( isset( $admin_notices[ $message_number ][ 'interval' ] ) ? $admin_notices[ $message_number ][ 'interval'] : $interval );
                
                // Add the interval to the start date to get an end date
                $date_array = explode( '/', $start_date );
                $date_array[1] += $admin_display_interval;
                $end_date = date( "n/j/Y", mktime( 0, 0, 0, $date_array[0], $date_array[1], $date_array[2] ) );

                // Ensure the notice hasn't been hidden and that the current date is between the start and end date
                if ( $admin_display_check == 0 && strtotime( $admin_display_start ) <= strtotime( $current_date ) && strtotime( $current_date ) <= strtotime( $end_date ) ) {

                        // Admin notice display output
                        echo '<div class="updated notice nf-admin-notice welcome-panel">';
                        printf(__('%1$s <div class="nf-admin-notice-dismiss-wrap"><a href="?nf_admin_notice_ignore=%2$s" class="nf-admin-notice-dismiss">Dismiss</a></div>'), $message, $message_number );
                        echo '</div>';

                        $this->notice_spam += 1;
                        return true;
                        
                // If the end date is already passed and the message hasn't been marked dismissed then mark it
                } elseif ( $admin_display_check != 1 && strtotime( $current_date ) > strtotime( $end_date ) ) {
                
                        $admin_notices[ $message_number ][ 'dismissed' ] = 1;
                        update_option( 'nf_admin_notice', serialize( $admin_notices ) );
                }
                
                return false;
        }

        // test for spam protection
        public function anti_notice_spam() {

                if ( $this->notice_spam >= $this->notice_spam_max ) {
                        return true;
                }
                
                return false;
        }
        
        // Ignore function that gets ran at admin init to ensure any messages that were dismissed get marked
        public function admin_notice_ignore() {

                // If user clicks to ignore the notice, update the option to not show it again
                if ( isset($_GET['nf_admin_notice_ignore']) && current_user_can( apply_filters( 'ninja_forms_admin_parent_menu_capabilities', 'manage_options' ) ) ) {

                        $admin_notices = ( get_option( 'nf_admin_notice' ) ? unserialize( get_option( 'nf_admin_notice' ) ) : array() );
                        $admin_notices[ $_GET[ 'nf_admin_notice_ignore' ] ][ 'dismissed' ] = 1;
                        update_option( 'nf_admin_notice', serialize( $admin_notices ) );
                }
        }
        
        // Special parameters function that is to be used in any extension of this class
        public function special_parameters() {
                // Intentionally left blank
        }
        
}

// Create the instance function for ease of use
function NF_Notices() {
    return NF_Notices::instance();
}

NF_Notices();
