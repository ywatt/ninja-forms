<?php

function nf_tmp_file_upload() {

    $file = array_values($_FILES)[0];

    echo "<pre>";
    var_dump($file);
    echo "</pre>";
    ?>

    <form id="theForm" action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="you-only-upload-once">
        <input type="submit">
    </form>

    <!--
    <script>
        jQuery(document).ready(function($) {
			var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
			var data = {
				action: 'nf_async_upload',
			};

            $("#theForm").ajaxForm({url: 'ajaxurl', type: 'post', data: data } );
        });
    </script>
    -->

    <?php
}

add_shortcode( 'nf_tmp_file_upload', 'nf_tmp_file_upload' );
