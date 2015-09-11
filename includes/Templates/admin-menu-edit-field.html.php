<script>
jQuery(document).ready(function($){
    $(".nf-item-edit").click(function(){
        $("#nf-builder").removeClass("nf-drawer-closed");
        $("#nf-builder").addClass("nf-drawer-opened");
        $(".nf-field-wrap:first-child").addClass("active");
    });
    $(".nf-close-drawer").click(function(){
        $("#nf-builder").removeClass("nf-drawer-opened");
        $("#nf-builder").addClass("nf-drawer-closed");
        $(".nf-field-wrap:first-child").removeClass("active");
    });
});
</script>
<div id="nf-builder">
    <div id="nf-header">
        <div id="nf-main-header">
            <div id="nf-logo"></div>
            <ul>
                <li><a class="active" href="#">Form Fields</a></li>
                <li><a href="#">Emails & Actions</a></li>
                <li><a href="#">Settings</a></li>
                <li><a class="preview" href="#">Live Preview<span class="dashicons dashicons-visibility"></span></a></li>
            </ul>
            <input class="nf-button primary" type="submit" value="Save Changes" />
            <a class="nf-cancel" href="#">Cancel</a>
        </div>

        <div id="nf-sub-header">
            <!-- <h2>Contact Form</h2> -->
            <a class="nf-add-new" href="#">Add new field</a>
            <!-- <input class="nf-button secondary" type="submit" value="Edit Emails and Actions" /> -->

        </div>

    </div>

    <div id="nf-main">
        <!-- main content area. Where fields and actions are rendered. -->
        <div id="nf-main-controls">
            <h2>Contact Form</h2>
            <input class="nf-button secondary" type="submit" value="Edit Emails and Actions" />
        </div>
        <div id="nf-form-wrap">

<?php
for ($i=0; $i < 25; $i++) {
    if ( 0 == $i ) {
        $field = 'First Name *';
    } else {
        $field = 'Textbox';
    }
    echo '<div class="nf-field-wrap">' . $field . '
        <ul class="nf-item-controls">
            <li class="nf-item-delete"><a href="#"><span class="dashicons dashicons-dismiss"></span><span class="nf-tooltip">Delete</span></a></li>
            <li class="nf-item-duplicate"><a href="#"><span class="dashicons dashicons-admin-page"></span><span class="nf-tooltip">Duplicate</span></a></li>
            <li class="nf-item-edit"><a href="#"><span class="dashicons dashicons-admin-generic"></span><span class="nf-tooltip">Edit</span><span class="nf-editing">Editing field</span></a></li>
        </ul>
    </div>';
}
?>
        </div>
    </div>

    <div id="nf-drawer">
        <!-- drawer area. This is where settings and add fields are rendered. -->
        <!-- THIS IS THE CONTENT FOR EDITING FIELDS -->
        <header class="nf-drawer-header">
            <h2><span class="dashicons dashicons-star-filled"></span>Editing Field</h2>
            <input type="submit" class="nf-button primary nf-close-drawer" value="Close" />
        </header>
        <div class="nf-one-half">
            <label>Label Name</label>
            <input type="text" value="First Name" />
        </div>
        <div class="nf-one-half">
            <label>Placeholder Text</label>
            <input type="text" value="Enter your first name" />
        </div>
        <div class="nf-one-half">
            <label>Label Position</label>
            <select>
                <option>Above Field</option>
                <option>Below Field</option>
                <option>Left of Field</option>
                <option>Right of Field</option>
                <option>Hide Label</option>
            </select>
        </div>
        <div class="nf-one-half">
            <label>Required Field</label>
            <input type="checkbox" class="nf-toggle" />
        </div>
    </div>

</div>
