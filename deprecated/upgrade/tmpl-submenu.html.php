<style>
    html {
        background: #fff;
    }
    h1 {
        line-height: 32px;
    }
    p {
        font-size: 16px;
    }
    ul {
        list-style-type: disc;
        margin-left: 20px;
        font-size: 16px;
    }
    .nf-logo {
        display: block;
        margin: 0 auto;
    }
    .nf-upgrade {
        margin: 0 auto;
        max-width: 800px;
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
    .dashicons-yes {
        color: green;
    }
    .dashicons-no {
        color: red;
    }
</style>

<img class="nf-logo" src="<?php echo NF_PLUGIN_URL . 'images/nf-logo.png'; ?>">
<div class="nf-upgrade">
    <h1>Congratulations!</h1>
    <h2>You are elgible to update to Ninja Forms THREE!</h2>

    <p>You are only moments away from the biggest thing to happen to the WordPress form building experience...ever</p>

    <p>Ninja Forms THREE is the most...</p>
    <ul>
        <li>intuitive</li>
        <li>powerful</li>
        <li>enjoyable</li>
    </ul>
    <p>...form builder you will ever use.</p>

    <h2>You are about to experience it live, right on your own site,<br />
    but first there are some things you should know.</h2>

    <ul>
        <li><strong>This is a Pre-release.</strong> This means that while we have tested everything that we could and we think it's ready for the world, there could be some minor bugs we were unable to detect. If you choose to update you are acknowledging this and promising to update us if you fund anything acting unexpected. Remember, you promised.</li>
        <li><strong></strong></li>
        <li><strong></strong></li>
    </ul>

    <hr>

    <h2>Form Upgrade Compatibility</h2>

    <table>
        <thead>
            <tr>
                <th>Form Title</th>
                <th>Ready to Convert</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach( $forms as $form ): ?>
            <tr>
                <td><?php echo $form[ 'form_title' ]; ?></td>
                <td><?php echo ( $form[ 'can_upgrade' ] ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
