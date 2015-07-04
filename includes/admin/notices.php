<?php if ( ! defined( 'ABSPATH' ) ) exit;

function nf_admin_notice() {
        NF_Notices()->admin_notice("THIS IS A MSG", "7/1/2015", 7);
        NF_Notices()->admin_notice("DOUBLE UP TEST", "7/2/2015", 6);

        $message = '<p>We notice that your Ninja Form has over 50 fields! Have you considered purchasing Multi-Part Forms?</p><p>Easily break up long forms into multiple pages. Control animation and direction. Show a confirmation page.</p>
        <div class="nf-extend-buttons"><a href="https://ninjaforms.com/extensions/multi-part-forms/" title="Multi-Part Forms" class="button-primary nf-button">Learn More</a></div>';
        NF_Notices()->admin_notice($message);
}

add_action( 'admin_notices', 'nf_admin_notice' );
