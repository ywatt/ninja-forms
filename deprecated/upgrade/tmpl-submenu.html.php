<style>
    html {
        background: #fff;
    }
    h1 {
        line-height: 32px;
    }
    h2 {
        margin: 40px auto 20px;
    }
    p {
        font-size: 16px;
        padding-top: 20px;
    }
    ol {
        font-size: 16px;
        margin-left: 40px;
        list-style-type: none;
    }
    hr {
        margin: 50px 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
    th {
        text-align: left;
    }
    th, td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2
    }


    .nf-logo {
        display: block;
        margin: 0 auto;
        max-width: 300px;
    }
    .nf-upgrade {
        margin: 0 auto;
        max-width: 800px;
    }

    /*
     * Dashicons
     */

    .dashicons-yes {
        color: green;
    }
    .dashicons-flag {
        color: red;
    }
    .dashicons-warning {
        color: #ffba00; /* WP Update Nag Yellow */
    }

    ol .dashicons {
        margin-top: 2px;
        margin-right: 8px;
        margin-left: -30px;
    }
    .dashicons-warning {
        color: #ffba00; /* WP Update Nag Yellow */
    }
</style>

<img class="nf-logo" src="<?php echo NF_PLUGIN_URL . 'images/nf-logo.png'; ?>">
<div class="nf-upgrade">
    <h1>Congratulations!</h1>
    <h2>You are elgible to update to Ninja Forms THREE!</h2>

    <p>You are only moments away from the biggest thing to ever happen to the WordPress form building experience.</p>

    <p>Ninja Forms THREE is the most <em>intuitive</em>, <em>powerful</em>, and <em>enjoyable</em> form builder you will ever use.</p>

    <h2>Before you update, we want to make you aware of a few <strong>very important points:</strong></h2>

    <ol>
        <li>
            <p>
                <span class="dashicons dashicons-warning"></span><strong>This is a pre-release.</strong>
                <br />We have tested everything we can and consider this release ready, but if you have any issues please report them via the "Get Help" item in the "Forms" menu.
            </p>
        </li>
        <li>
            <p>
                <span class="dashicons dashicons-warning"></span><strong>Calculations will not convert.</strong>
                <br />Any forms with calculations will be converted to Ninja Forms THREE, but calculations within those forms will need recreated as a result of our vastly improved calculations system.
            </p>
        </li>
        <li>
            <p>
                <span class="dashicons dashicons-warning"></span><strong>We have resources to help you with the transition to THREE.</strong>
                <br />The Ninja Forms THREE documentation, development process, FAQ, and more <a href='http://ninjaforms.com/three/'>can be found here.</a>
            </p>
        </li>
    </ol>

    <hr>

    <h2>Form Upgrade Compatibility</h2>

    <span class="dashicons dashicons-yes"></span> = No Issues Detected &nbsp; <span class="dashicons dashicons-flag"></span> = Will Need Attention

    <table>
        <thead>
            <tr>
                <th colspan="2">Form Title</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach( $forms as $form ): ?>
            <tr>
                <td><?php echo $form[ 'form_title' ]; ?></td>
                <td>
                    <?php echo ( $form[ 'can_upgrade' ] ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-flag"></span>'; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
