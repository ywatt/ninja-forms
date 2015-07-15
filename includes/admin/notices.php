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

function nf_admin_notices( $notices ) {

    // $notices['bleep5'] = array( 'msg' => __( 'This is a test message', 'ninja-forms' ), 'start' => '7/10/2015', 'int' => 7 );
    // $notices['test2'] = array( 'msg' => __( 'This is 2nd test message', 'ninja-forms' ), 'start' => '7/7/2015' );
    $notices['test77'] = array( 'msg' => __( 'This is 3rd test message', 'ninja-forms' ), 'int' => 0 );
    // $notices['test4'] = array( 'msg' => __( 'This is 4th test message', 'ninja-forms' ), 'pages' => array( 'ninja-forms' ) );


    return $notices;
}
// This function is used to hold all of the basic notices
// Date format accepts most formats but can get confused so preferred methods are m/d/Y or d-m-Y

add_filter( 'nf_admin_notices', 'nf_admin_notices' );

// Require any files that contain class extensions for NF_Notices
require_once( NF_PLUGIN_DIR . 'includes/admin/notices-multipart.php' );
