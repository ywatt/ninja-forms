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

        NF_Notices()->admin_notice("THIS IS A MSG - test", "7/6/2015", 7);
        
        NF_Notices()->admin_notice("DOUBLE UP TEST - Yo Bro", "7/6/2015", 10);

}

// Require any files that contain class extensions for NF_Notices
require_once( NF_PLUGIN_DIR . 'includes/admin/notices-multipart.php' );
