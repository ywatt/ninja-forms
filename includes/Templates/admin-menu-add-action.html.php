<script>
jQuery(document).ready(function($){
    $(".nf-add-new").click(function(){
        $("#nf-builder").removeClass("nf-drawer-closed");
        $("#nf-builder").addClass("nf-drawer-opened");
        //$(".nf-field-wrap:first-child").addClass("active");
        //$("#action-0 .nf-item-controls").addClass("nf-editing");
    });
    $(".nf-close-drawer").click(function(){
        $("#nf-builder").removeClass("nf-drawer-opened");
        $("#nf-builder").addClass("nf-drawer-closed");
        //$(".nf-field-wrap:first-child").removeClass("active");
        //$("#action-0 .nf-item-controls").removeClass("nf-editing");
    });

    $(".nf-toggle-drawer").click(function(){
        $("#nf-drawer").toggleClass("nf-drawer-expand");
    });
});
</script>
<div id="nf-builder">
    <div id="nf-header">
        <div id="nf-app-header">
            <div id="nf-logo"></div>
            <ul>
                <li><a href="#">Form Fields</a></li>
                <li class="selected"><a class="active" href="#">Emails & Actions</a></li>
                <li><a href="#">Settings</a></li>
                <li><a class="preview" href="#">Live Preview<span class="dashicons dashicons-visibility"></span></a></li>
            </ul>
            <input class="nf-button primary" type="submit" value="Publish Changes" />
            <a class="nf-cancel" href="#">Cancel</a>
        </div>

        <div id="nf-app-sub-header">
            <!-- <h2>Contact Form</h2> -->
            <a class="nf-add-new" href="#">Add new action</a>
            <!-- <input class="nf-button secondary" type="submit" value="Edit Emails and Actions" /> -->

        </div>

    </div>
<?php function nf_display_controls() {
    echo '<ul class="nf-item-controls">
        <li class="nf-item-delete"><a href="#"><span class="dashicons dashicons-dismiss"></span><span class="nf-tooltip">Delete</span></a></li>
        <li class="nf-item-duplicate"><a href="#"><span class="dashicons dashicons-admin-page"></span><span class="nf-tooltip">Duplicate</span></a></li>
        <li class="nf-item-edit"><a href="#"><span class="dashicons dashicons-admin-generic"></span><span class="nf-tooltip">Edit</span><span class="nf-item-editing">Editing field</span></a></li>
    </ul>';
} ?>
    <div id="nf-main">
        <!-- main content area. Where fields and actions are rendered. -->
        <div id="nf-main-header">
            <h2>Contact Form</h2>
            <input class="nf-button secondary" type="submit" value="Manage Settings" />
        </div>

        <div id="nf-main-content">
            <table id="nf-table-display">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox" class="nf-toggle" checked /></td>
                        <td>Save to Database</td>
                        <td>Save Submissions</td>
                        <td><?php nf_display_controls(); ?></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="nf-toggle" checked /></td>
                        <td>Email to Admin</td>
                        <td>Email</td>
                        <td><?php nf_display_controls(); ?></td>
                    </tr>
                    <tr class="nf-deactivated">
                        <td><input type="checkbox" class="nf-toggle" /></td>
                        <td>Thank You Message</td>
                        <td>Sucess Message</td>
                        <td><?php nf_display_controls(); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div id="nf-drawer">
        <!-- drawer area. This is where settings and add fields are rendered. -->
        <!-- THIS IS THE CONTENT FOR EDITING FIELDS -->
        <header class="nf-drawer-header">
            <div class="nf-search">
                <input type="search" class="" value="" placeholder="Search" />
            </div>
            <input type="submit" class="nf-button primary nf-close-drawer" value="Done" />
        </header>

        <section class="nf-settings nf-action-items">
            <h3>Installed Actions</h3>
            <div class="nf-one-third">
                <div class="nf-item">Email</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Success Message</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Redirect</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Save Submissions</div>
            </div>
        </section>
        <section class="nf-settings nf-action-items">
            <h3>Available Actions</h3>
            <div class="nf-one-third">
                <div class="nf-item">MailChimp</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Insightly</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Constant Contact</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Campaign Monitor</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Slack</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Trello</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Create Post</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Salesforce</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Text Message</div>
            </div>
        </section>

        <a class="nf-toggle-drawer">
            <span class="dashicons dashicons-admin-collapse"></span><span class="nf-expand-off">Full screen</span><span class="nf-expand-on">Half screen</span>
        </a>
    </div>

</div>
