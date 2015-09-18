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

    $(".nf-toggle-drawer").click(function(){
        $("#nf-drawer").toggleClass("nf-drawer-expand");
    });
    $(".nf-item-expand").click(function(){
        $(".nf-group-wrap").toggleClass("expanded");
    });
});
</script>

<?php function nf_display_controls() {
    echo '<ul class="nf-item-controls">
        <li class="nf-item-expand"><a href="#"><span class="dashicons dashicons-admin-collapse"></span><span class="nf-tooltip">Expand</span></a></li>
        <li class="nf-item-delete"><a href="#"><span class="dashicons dashicons-dismiss"></span><span class="nf-tooltip">Delete</span></a></li>
        <li class="nf-item-duplicate"><a href="#"><span class="dashicons dashicons-admin-page"></span><span class="nf-tooltip">Duplicate</span></a></li>
        <li class="nf-item-edit"><a href="#"><span class="dashicons dashicons-admin-generic"></span><span class="nf-tooltip">Edit</span><span class="nf-item-editing">Editing field</span></a></li>
    </ul>';
} ?>
<div id="nf-builder">
    <div id="nf-header">
        <div id="nf-app-header">
            <div id="nf-logo"></div>
            <ul>
                <li class="selected"><a class="active" href="#">Form Fields</a></li>
                <li><a href="#">Emails & Actions</a></li>
                <li><a href="#">Settings</a></li>
                <li><a class="preview" href="#">Live Preview<span class="dashicons dashicons-visibility"></span></a></li>
            </ul>
            <input class="nf-button primary" type="submit" value="Publish Changes" />
            <a class="nf-cancel" href="#">Cancel</a>
        </div>

        <div id="nf-app-sub-header">
            <a class="nf-add-new" href="#">Add new field</a><h2>Contact Form</h2>

            <!-- <input class="nf-button secondary" type="submit" value="Edit Emails and Actions" /> -->

        </div>

    </div>

    <div id="nf-main">

        <!-- main content area. Where fields and actions are rendered. -->
        <div id="nf-main-header">

            <input class="nf-button secondary" type="submit" value="Edit Emails and Actions" />
        </div>
        <div id="nf-main-content">

            <div class="nf-field-wrap">First Name
            <?php nf_display_controls(); ?></div>

            <div class="nf-field-wrap">Last Name
            <?php nf_display_controls(); ?></div>

            <div class="nf-group-wrap">
                Mailing Address (4 fields)
                <?php nf_display_controls(); ?>
                <div class="nf-field-wrap">Street Address
                <?php nf_display_controls(); ?></div>

                <div class="nf-field-wrap">City
                <?php nf_display_controls(); ?></div>

                <div class="nf-field-wrap">State
                <?php nf_display_controls(); ?></div>

                <div class="nf-field-wrap">Zip Code
                <?php nf_display_controls(); ?></div>
            </div>

            <div class="nf-field-wrap">Message
            <?php nf_display_controls(); ?></div>

            <div class="nf-field-wrap">Submit
            <?php nf_display_controls(); ?></div>

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
                <div class="nf-item">Textbox</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Textarea</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Checkbox</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Dropdown</div>
            </div>
        </section>
        <section class="nf-settings">
            <h3>Common Fields</h3>
            <div class="nf-one-third">
                <div class="nf-item">Textbox</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Textarea</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Checkbox</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Dropdown</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Checkbox List</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Radio List</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">File Upload</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Multi-Select</div>
            </div>
            <div class="nf-one-third">
                <div class="nf-item">Hidden Field</div>
            </div>
        </section>

        <a class="nf-toggle-drawer">
            <span class="dashicons dashicons-admin-collapse"></span><span class="nf-expand-off">Full screen</span><span class="nf-expand-on">Half screen</span>
        </a>
    </div>

</div>
