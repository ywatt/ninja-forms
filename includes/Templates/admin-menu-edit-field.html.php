<script>
jQuery(document).ready(function($){
    $(".nf-item-edit").click(function(){
        $("#nf-builder").removeClass("nf-drawer-closed");
        $("#nf-builder").addClass("nf-drawer-opened");
    });
    $(".nf-close-drawer").click(function(){
        $("#nf-builder").removeClass("nf-drawer-opened");
        $("#nf-builder").addClass("nf-drawer-closed");
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
    echo '<div class="nf-field-wrap">Field
        <ul class="nf-item-controls">
            <li class="nf-item-delete"><a href="#"><span class="dashicons dashicons-dismiss"></span><span class="nf-tooltip">Delete</span></a></li>
            <li class="nf-item-duplicate"><a href="#"><span class="dashicons dashicons-admin-page"></span><span class="nf-tooltip">Duplicate</span></a></li>
            <li class="nf-item-edit"><a href="#"><span class="dashicons dashicons-admin-generic"></span><span class="nf-tooltip">Edit</span></a></li>
        </ul>
    </div>';
}
?>
        </div>
    </div>

    <div id="nf-drawer">
        <!-- drawer area. This is where settings and add fields are rendered. -->
        <!-- THIS IS THE CONTENT FOR EDITING FIELDS -->
        <header class="nf-full">
            <h2>Editing Field</h2>
            <input type="submit" class="nf-button primary nf-close-drawer" value="Close" />
        </header>
        <div class="nf-one-half">
            <label>Label Name</label>
            <input type="text" />
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
        <div class="nf-full">
            <label>Class Name</label>
            <input type="text" />
        </div>
    </div>

    <!-- THIS IS THE CONTENT FOR ADDING FIELDS
    <header class="nf-full">
        <input type="search" />
        <span><input type="submit" class="close-add-fields" value="DONE" /></span>
    </header>

    <div class="nf-reservoir">
        <span>Textbox</span><span>Textbox</span><span>Textbox</span><span>Textbox</span><span>Textbox</span><span>Textbox</span><span>Textbox</span><span>Textbox</span><span>Textbox</span>
    </div>

    <h3>Basic Fields</h3>

    <div class="nf-one-third">
        <div class="nf-field-button">Textbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Textarea</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Checkbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Dropdown</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Mult-Select</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Radio List</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Hidden Field</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Button</div>
    </div>


    <h3>Basic Fields</h3>

    <div class="nf-one-third">
        <div class="nf-field-button">Textbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Textarea</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Checkbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Dropdown</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Mult-Select</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Radio List</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Hidden Field</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Button</div>
    </div>

    <div class="nf-full">
        <h3>Basic Fields</h3>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Textbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Textarea</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Checkbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Dropdown</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Mult-Select</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Radio List</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Hidden Field</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Button</div>
    </div>

    <div class="nf-full">
        <h3>Basic Fields</h3>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Textbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Textarea</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Checkbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Dropdown</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Mult-Select</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Radio List</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Hidden Field</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Button</div>
    </div>

    <div class="nf-full">
        <h3>Basic Fields</h3>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Textbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Textarea</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Checkbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Dropdown</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Mult-Select</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Radio List</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Hidden Field</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Button</div>
    </div>
    -->
</div>
