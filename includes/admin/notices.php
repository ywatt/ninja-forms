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

    $one_week_support = add_query_arg( array( 'nf_admin_notice_temp_ignore' => 'one_week_support', 'nf_int' => 7 ) );
    $notices['one_week_support'] = array(
        'title' => __( 'How You Doin?', 'ninja-forms' ),
        'msg' => __( 'Link section contains the links. Perm dismiss is linking to the same thing that the right hand corner links too. Temp dismiss also has an nf_int set which overrides the default 14 day interval.', 'ninja-forms' ),
        'link' => '<li><span class="dashicons dashicons-media-text"></span><a href="#">Go Somewhere Else</a></li>
                    <li><span class="dashicons dashicons-sos"></span><a href="' . $one_week_support . '">' . __( 'Maybe Later' ,'ninja-forms' ) . '</a></li>
                    <li><span class="dashicons dashicons-sos"></span><a href="?nf_admin_notice_ignore=one_week_support">Perm Dismiss</a></li>',
        'int' => 0
    );

    return $notices;
}
// This function is used to hold all of the basic notices
// Date format accepts most formats but can get confused so preferred methods are m/d/Y or d-m-Y

add_filter( 'nf_admin_notices', 'nf_admin_notices' );

// Require any files that contain class extensions for NF_Notices
require_once( NF_PLUGIN_DIR . 'includes/admin/notices-multipart.php' );
