<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Notices page to house all of the admin notices for Core
 *
 * Can be simply used be adding another line into the nf_admin_notices() function
 *
 * The class NF_Notices in notices-class.php can be extended to create more advanced notices to include triggered events
 *
 * @since 2.9
 */

// This function is used to hold all of the basic notices
// Date format accepts most formats but can get confused so preferred methods are m/d/Y or d-m-Y

function nf_admin_notices() {

        Ninja_Forms()->notices->admin_notice("THIS IS A MSG - Testing a simple message #1", current_time( "n/j/Y" ), 7);
        
        Ninja_Forms()->notices->admin_notice("DOUBLE UP TEST - Testing spam filter set to 1", current_time( "n/j/Y" ), 10);

}

// Require any files that contain class extensions for NF_Notices
require_once( NF_PLUGIN_DIR . 'includes/admin/notices-multipart.php' );
