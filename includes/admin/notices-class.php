<?php if ( ! defined( 'ABSPATH' ) ) exit;


class NF_Notices
{
        static $instance;
        
        public static function instance()
        {
                if ( ! isset( self::$instance ) ) {
                        self::$instance = new NF_Notices();
                }

                return self::$instance;
        }

        public function __construct(){
                add_action('admin_init', array( $this, 'admin_notice_ignore' ) );
        }
        
        /* Display a notice that can be dismissed */

        public function admin_notice( $message, $start_date = null, $interval = 14, $triggered = 0 ) {

                $current_date = date( "n/j/Y" );
                $start_date = ( $start_date != null ? $start_date : $current_date );
                $start_date = date( "n/j/Y", strtotime( $start_date ) );

                $admin_notices = ( get_option( 'nf_admin_notice' ) ? unserialize( get_option( 'nf_admin_notice' ) ) : array() );

                foreach ($admin_notices as $key => $val) {
                        if ($val['message'] === $message) {
                            $message_number = $key;
                        }
                }
                
                if ( ! isset( $message_number ) ) {
                        $admin_notices[][ 'message' ] = $message;
                        end( $admin_notices );
                        $message_number = key( $admin_notices );
                        update_option( 'nf_admin_notice', serialize( $admin_notices ) );
                }

                $admin_display_check = ( isset( $admin_notices[ $message_number ][ 'dismissed' ] ) ? $admin_notices[ $message_number ][ 'dismissed'] : 0 );
                $admin_display_start = ( isset( $admin_notices[ $message_number ][ 'startdate' ] ) ? $admin_notices[ $message_number ][ 'startdate'] : $start_date );
                $admin_display_interval = ( isset( $admin_notices[ $message_number ][ 'interval' ] ) ? $admin_notices[ $message_number ][ 'interval'] : $interval );
                
                $date_array = explode( '/', $start_date );
                $date_array[1] += $admin_display_interval;
                $end_date = date( "n/j/Y", mktime( 0, 0, 0, $date_array[0], $date_array[1], $date_array[2] ) );

                if ( $admin_display_check == 0 && strtotime( $admin_display_start ) <= strtotime( $current_date ) && strtotime( $current_date ) <= strtotime( $end_date ) ) {
                        if ( current_user_can( apply_filters( 'ninja_forms_admin_parent_menu_capabilities', 'manage_options' ) ) && get_current_screen()->id === 'dashboard' ) {
                                echo '<div class="updated notice nf-admin-notice welcome-panel">';
                                printf(__('%1$s <div class="nf-admin-notice-dismiss-wrap"><a href="?nf_admin_notice_ignore=%2$s" class="nf-admin-notice-dismiss">Dismiss</a></div>'), $message, $message_number );
                                echo '</div>';
                                return true;
                        }
                        
                } elseif ( $admin_display_check != 1 ) {
                
                        $admin_notices[ $message_number ][ 'dismissed' ] = 1;
                        update_option( 'nf_admin_notice', serialize( $admin_notices ) );
                }
                
                return false;
        }

        public function admin_notice_ignore() {

                /* If user clicks to ignore the notice, update the option to not show it again */
                if ( isset($_GET['nf_admin_notice_ignore']) && current_user_can( apply_filters( 'ninja_forms_admin_parent_menu_capabilities', 'manage_options' ) ) ) {

                        $admin_notices = ( get_option( 'nf_admin_notice' ) ? unserialize( get_option( 'nf_admin_notice' ) ) : array() );
                        $admin_notices[ $_GET[ 'nf_admin_notice_ignore' ] ][ 'dismissed' ] = 1;
                        update_option( 'nf_admin_notice', serialize( $admin_notices ) );
                }
        }
        
}

function NF_Notices() {
    return NF_Notices::instance();
}

NF_Notices();
