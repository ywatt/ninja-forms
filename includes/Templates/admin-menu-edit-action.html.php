<script>
jQuery(document).ready(function($){
    $(".nf-item-edit").click(function(){
        $("#nf-builder").removeClass("nf-drawer-closed");
        $("#nf-builder").addClass("nf-drawer-opened");
        $(".nf-field-wrap:first-child").addClass("active");
        $("#action-3 .nf-item-controls").addClass("nf-editing");
    });
    $(".nf-close-drawer").click(function(){
        $("#nf-builder").removeClass("nf-drawer-opened");
        $("#nf-builder").addClass("nf-drawer-closed");
        $(".nf-field-wrap:first-child").removeClass("active");
        $("#action-3 .nf-item-controls").removeClass("nf-editing");
    });
});
</script>
<div id="nf-builder">
    <div id="nf-header">
        <div id="nf-app-header">
            <div id="nf-logo"></div>
            <ul>
                <li><a href="#">Form Fields</a></li>
                <li><a class="active" href="#">Emails & Actions</a></li>
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
        <li class="nf-item-edit"><a href="#"><span class="dashicons dashicons-admin-generic"></span><span class="nf-tooltip">Edit</span><span class="nf-item-editing">In Progress</span></a></li>
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
                    <tr id="action-3" class="nf-new-action">
                        <td></td>
                        <td>Email to Use</td>
                        <td>Email</td>
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
            <h2>Email Action</h2>
            <input type="submit" class="nf-button primary nf-close-drawer" value="Close" />
        </header>
        <section class="nf-settings">
            <div class="nf-full">
                <label>Action Name</label>
                <input type="text" value="Email to Use" />
            </div>
            <div class="nf-one-half">
                <label>From Name</label>
                <input type="text" value="James Laws" />
            </div>
            <div class="nf-one-half">
                <label>From Email</label>
                <input type="text" value="james@wpninjas.com" />
            </div>
            <div class="nf-full">
                <label>To</label>
                <input type="text" value="" />
            </div>
            <div class="nf-full">
                <label>Subject</label>
                <input type="text" value="Email to Use" />
            </div>
            <div class="nf-full">
                <label>Email Message</label>
                <?php wp_editor( 'Your Email Message', 2, $settings = array() ); ?>
            </div>
        </section>

    </div>

</div>
