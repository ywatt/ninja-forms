<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Adds a global exception handler for reporting on form rendering issues.
 *
 * Note: Exceptions before `document.ready` do not break scripts inside of `document.ready`.
 */
final class NF_ExceptionHandlerJS
{
    public function __construct()
    {
        add_action( 'wp_head', array( $this, 'wp_head' ), 6 );
    }

    public function wp_head()
    {
        if( ! current_user_can( 'manage_options' ) ) return;
        ?>
        <script type="text/javascript">
            window.addEventListener( 'error', function (e) {

                var source = e.filename.match( /(plugins|themes)\/([a-zA-Z0-9]|-|_|)+\//gi ) || e.filename;

                var message = document.createElement( 'pre' );
                message.innerHTML = '<span style="width: 100%;display:inline-block;text-align: center;text-decoration:underline;">This message is displayed for the ADMIN ONLY.</span>' +
                    '\r\rNinja Forms detected a JavaScript error.' +
                    '\rThis error may cause issues with your form.' +
                    '\r\r\<span style="text-decoration:underline;">Details</span>' +
                    '\rSource: ' + source +
                    '\r<span style="color:red;">' + e.error + '</span>';

                // Replace form loading animation.
                var forms = document.getElementsByClassName( 'nf-form-cont' );
                for ( var i = 0; i < forms.length; i++ ) {
                    forms[i].append( message );
                }
            });
        </script>
        <?php
    }
} // END CLASS NF_ExceptionHandlerJS
