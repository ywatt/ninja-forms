<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * NF_Notices_Multipart Class
 *
 * Extends NF_Notices to check for 50 or more fields in a single form and if multi-part forms is not installed before throwing an admin notice.
 *
 * @since 2.9
 */

class NF_Notices_Multipart extends NF_Notices
{
        // Basic actions to run
        public function __construct(){

                // Runs the visibility checks for admin notices after all needed core files are loaded
                add_filter( 'nf_admin_notices', array( $this, 'special_parameters' ) );

        }
        
        // Function to do all the special checks before running the notice
        public function special_parameters( $admin_notices ){

                // Check if on builder
                if ( ! $this->admin_notice_pages( array( array( 'ninja-forms', 'builder' ) ) ) ) {
                        return $admin_notices;
                }
                
                // Check for 50 fields in one form
                $field_check = 0;
                $all_fields = ninja_forms_get_all_fields();
                        
                if ( is_array( $all_fields ) ) {
                        $count = array();

                        foreach ( $all_fields as $key => $val ) {
                                $form_id = $all_fields[ $key ][ 'form_id' ];
                                if ( ! isset( $count[ $form_id ] ) ) {
                                        $count[ $form_id ] = 1;
                                } else {
                                        $count[ $form_id ]++;
                                }
                        }

                        foreach ( $count as $form_id => $field_count ) {
                                if ( $field_count >=5 ) {
                                        $field_check = 1;
                                }
                        }
                }
                        
                // Check for multi-part forms installed and if the above passes
                if ( ! is_plugin_active( 'ninja-forms-multi-part/multi-part.php' ) && $field_check == 1 ) {
                        // Add notice
                        $message = 'My, what a long form you have!</p><p>We notice that your Ninja Form has over 50 fields! Have you considered purchasing Multi-Part Forms?</p><p>Easily break up long forms into multiple pages. Control animation and direction. Show a confirmation page.</p>';
                        $admin_notices[ 'multi-part12' ] = array(
                            'title' => __( 'Check out Multi-Part Forms', 'ninja-forms' ),
                            'msg' => __( $message, 'ninja-forms' )
                        );

                }
                
                return $admin_notices;

        }
}

return new NF_Notices_Multipart();
