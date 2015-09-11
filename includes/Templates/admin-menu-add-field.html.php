<script>
jQuery(document).ready(function($){
    $(".nf-add-new").click(function(){
        $("#nf-builder").removeClass("nf-drawer-closed");
        $("#nf-builder").addClass("nf-drawer-opened");
        //$(".nf-field-wrap:first-child").addClass("active");
    });
    $(".nf-close-drawer").click(function(){
        $("#nf-builder").removeClass("nf-drawer-opened");
        $("#nf-builder").addClass("nf-drawer-closed");
        //$(".nf-field-wrap:first-child").removeClass("active");
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
            <input class="nf-button primary" type="submit" value="Publish Changes" />
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
            <div class="nf-search">
                <input type="search" class="" value="" placeholder="Search" />
            </div>
            <input type="submit" class="nf-button primary nf-close-drawer" value="Done" />
        </header>
        <section class="nf-settings">
            <div class="nf-reservoir">
                <span>Textbox<span class="dashicons dashicons-dismiss"></span></span>
                <span>First Name<span class="dashicons dashicons-dismiss"></span></span>
                <span>Checkbox<span class="dashicons dashicons-dismiss"></span></span>
                <span>Textarea<span class="dashicons dashicons-dismiss"></span></span>
            </div>
        </section>
        <section class="nf-settings nf-favorites">
            <h3>Saved Fields</h3>
            <div class="nf-one-third">
                <div class="nf-field">Textbox</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-field">Textarea</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-field">Checkbox</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-field">Dropdown</div>
            </div>
        </section>
        <section class="nf-settings">
            <h3>Common Fields</h3>
            <div class="nf-one-third">
                <div class="nf-field">Textbox</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-field">Textarea</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-field">Checkbox</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-field">Dropdown</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-field">Checkbox List</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-field">Radio List</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-field">File Upload</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-field">Multi-Select</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-field">Hidden Field</div>
            </div>
        </section>
    </div>

</div>
