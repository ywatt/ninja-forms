<style>

    #nfThreeFormConvert {
        display: none;
    }

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
        margin-bottom: 20px;
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

    th:nth-child( 1 ),
    td:nth-child( 1 ) {
        width: 10%;
    }
    th:nth-child( 2 ),
    td:nth-child( 2 ) {
        width: 80%;
    }

    th:nth-child( 3 ),
    td:nth-child( 3 ) {
        width: 10%;
    }


    tbody tr:nth-child(odd) {
        background-color: #f2f2f2
    }


    .nf-logo {
        display: block;
        margin: 0 auto;
        max-width: 300px;
    }
    .nf-upgrade {
        margin: 0 auto 50px auto;
        max-width: 800px;
    }

    /*
     * Dashicons
     */

    .dashicons-yes {
        color: green;
    }
    .dashicons-flag {
        color: #ffba00; /* WP Update Nag Yellow */
    }
    .dashicons-warning {
        color: gray;
    }

    .dashicons.spin {
        margin-left: -1px;
        animation: dashicons-spin 1s infinite;
        animation-timing-function: linear;
    }
    @keyframes dashicons-spin {
        0% {
            transform: rotate( 0deg );
        }
        100% {
            transform: rotate( 360deg );
        }
    }

    ol .dashicons {
        margin-top: 2px;
        margin-right: 8px;
        margin-left: -30px;
    }

    /*
     * Progress Bar
     */
    .progress-bar,
    .progress-bar--wrapper {
        height: 10px;
    }
    .progress-bar {
        width: 0;
        background-color: green;
    }
    .progress-bar--wrapper {
        width: 100%;
    }

    /*
     * Button
     */
    #goToThree,
    #goNinjaGo {
        display: none;
    }
    #goToThree {
        text-decoration: none;
        width: 100px;
        text-align: center;
    }
    #goToThree,
    button.button.go-ninja-go {
        color: white;
        background-color: green;
        padding: 10px 20px;
        height: auto;
        margin: auto;
        border: 2px solid transparent;
    }
    #goToThree:hover,
    #goToThree:active,
    button.button.go-ninja-go:hover,
    button.button.go-ninja-go:active {
        color: green;
        font-weight: bold;
        border-color: green;
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

    <div id="nfThreeFormCheck">

        <h2>Form Upgrade Compatibility</h2>

        <?php $no_issues_detected  = __( 'No Issues Detected', 'ninja-forms' ); ?>
        <?php $will_need_attention = __( 'Will Need Attention', 'ninja-forms' ); ?>
        <span class="dashicons dashicons-yes"></span> = <?php echo $no_issues_detected; ?> &nbsp; <span class="dashicons dashicons-flag"></span> = <?php echo $will_need_attention; ?>

        <table id="nfThreeFormCheckTable">
            <thead>
            <tr>
                <th>ID#</th>
                <th>Title</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <tr id="nfThreeFormCheckEmptyRow">
                <td colspan="3" style="text-align: center;">
                    <span class="dashicons dashicons-update spin"></span>
                    <div class="progress-bar--wrapper">
                        <div class="progress-bar"></div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <button id="goNinjaGo" class="button go-ninja-go"><?php echo __( 'Update to THREE', 'ninja-forms' ); ?></button>

    </div>

    <div id="nfThreeFormConvert">

        <h2>Converting Forms</h2>

        <table id="nfThreeFormConvertTable">
            <thead>
            <tr>
                <th>ID#</th>
                <th>Title</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
                <tr class="js-tmp-row">
                    <td colspan="3" style="text-align: center;">
                        <span class="dashicons dashicons-update spin"></span>
                    </td>
                </tr>
            </tbody>
        </table>

        <a href="<?php echo admin_url( '?nf-switcher=upgrade' ); ?>" id="goToThree">Go To Three</a>

    </div>

</div>
