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
    $notices['tempdis'] = array(
        'title' => __( 'Temporary Dismiss', 'ninja-forms' ),
        'msg' => __( 'Link section contains the links. Perm dismiss is linking to the same thing that the right hand corner links too. Temp dismiss also has an nf_int set which overrides the default 14 day interval.', 'ninja-forms' ),
        'link' => '<li><span class="dashicons dashicons-media-text"></span><a href="#">Go Somewhere Else</a></li>
                    <li><span class="dashicons dashicons-sos"></span><a href="?nf_admin_notice_temp_ignore=tempdis&nf_int=1">Temp Dismiss</a></li>
                    <li><span class="dashicons dashicons-sos"></span><a href="?nf_admin_notice_ignore=tempdis">Perm Dismiss</a></li>',
        'int' => 0
    );
    $notices['itsmaslug'] = array(
        'title' => __( 'Paypal Express', 'ninja-forms' ),
        'msg' => __( 'Learn how to use Paypal Express more efficiently.', 'ninja-forms' ),
        'link' => '<li><span class="dashicons dashicons-media-text"></span>DOCS: How to Configure your PayPal Express Add-on</li>
                    <li><span class="dashicons dashicons-sos"></span>Get Support</li>',
        'int' => 0
    );
    $notices['notitle'] = array(
        'msg' => __( 'Learn how to use Paypal Express more efficiently.', 'ninja-forms' ),
        'link' => '<li><span class="dashicons dashicons-media-text"></span>DOCS: How to Configure your PayPal Express Add-on</li>
                    <li><span class="dashicons dashicons-sos"></span>Get Support</li>',
        'int' => 0
    );
    $notices['nomsg'] = array(
        'title' => __( 'Paypal Express', 'ninja-forms' ),
        'link' => '<li><span class="dashicons dashicons-media-text"></span>DOCS: How to Configure your PayPal Express Add-on</li>
                    <li><span class="dashicons dashicons-sos"></span>Get Support</li>',
        'int' => 0
    );
    $notices['nolink'] = array(
        'title' => __( 'Paypal Express', 'ninja-forms' ),
        'msg' => __( 'Learn how to use Paypal Express more efficiently.', 'ninja-forms' ),
        'int' => 0
    );
    // $notices['test4'] = array( 'msg' => __( 'This is 4th test message', 'ninja-forms' ), 'pages' => array( 'ninja-forms' ) );


    return $notices;
}
// This function is used to hold all of the basic notices
// Date format accepts most formats but can get confused so preferred methods are m/d/Y or d-m-Y

add_filter( 'nf_admin_notices', 'nf_admin_notices' );

// Require any files that contain class extensions for NF_Notices
require_once( NF_PLUGIN_DIR . 'includes/admin/notices-multipart.php' );
