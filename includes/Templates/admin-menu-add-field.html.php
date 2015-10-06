<div id="nf-builder" class="grey"></div>

<script id="nf-tmpl-builder" type="text/template">
    <div id="nf-header"></div>
    <div id="nf-main"></div>
    <div id="nf-menu-drawer"></div>
    <div id="nf-drawer"></div>
</script>

<script id="nf-tmpl-header" type="text/template">
    <div id="nf-app-header"></div>

    <div id="nf-app-sub-header">
        <a class="nf-add-new" href="#">Add new field</a>
        <h2>Contact Form</h2>
    </div>
</script>

<script id="nf-tmpl-app-header" type="text/template">
    <div id="nf-logo"></div>
    <ul>
        <li><a href="#">Form Fields</a></li>
        <li><a href="#">Emails & Actions</a></li>
        <li><a href="#">Settings</a></li>
        <li><a class="preview" href="#">Preview Changes<span class="dashicons dashicons-visibility"></span></a></li>
    </ul>
    <input class="nf-button primary" type="submit" value="Save" />
    <a class="nf-mobile" href="#"><span class="dashicons dashicons-editor-ul"></span></a>
    <a class="nf-cancel" href="#">Cancel</a>
</script>

<script id="nf-tmpl-main" type="text/template">
    <div id="nf-main-header"></div>
    <div id="nf-main-content"></div>
</script>

<script id="nf-tmpl-main-header" type="text/template">
    <!-- <input class="nf-button secondary" type="submit" value="Edit Emails and Actions" /> -->
</script>

<script id="nf-tmpl-main-content" type="text/template">
    <div class="nf-fields-empty">
        <h3>Add form fields</h3>
        <p>Get started by adding your first form field. Just click the plus and select the fields you want. It’s that easy.</p>
    </div>
</script>

<script id="nf-tmpl-menu-drawer" type="text/template">
    <ul>
        <li class="nf-publish">Publish</li>
    </ul>
    <ul>
        <li><a href="#"><span class="dashicons dashicons-menu"></span>Form Fields</a></li>
        <li><a href="http://three.ninjaforms.com/wp-admin/admin.php?page=edit-action"><span class="dashicons dashicons-external"></span>Emails & Actions</a></li>
        <li><a href="#"><span class="dashicons dashicons-admin-generic"></span>Settings</a></li>
        <li><a href="#"><span class="dashicons dashicons-visibility"></span>Preview</a></li>
    </ul>
</script>

<script id="nf-tmpl-drawer" type="text/template">
    <!-- drawer area. This is where settings and add fields are rendered. -->
    <!-- THIS IS THE CONTENT FOR EDITING FIELDS -->
    <header class="nf-drawer-header">
        <div class="nf-search">
            <input type="search" class="" value="" placeholder="Search" />
        </div>
        <a href="#" class="nf-button primary nf-close-drawer">Done</a>
    </header>
    <section class="nf-settings">
        <div class="nf-reservoir">
            <span class="nf-item-dock first-name">First Name<span class="dashicons dashicons-dismiss"></span></span>
            <span class="nf-item-dock last-name">Last Name<span class="dashicons dashicons-dismiss"></span></span>
            <span class="nf-item-dock email">Email<span class="dashicons dashicons-dismiss"></span></span>
            <span class="nf-item-dock textarea">Textarea<span class="dashicons dashicons-dismiss"></span></span>
            <span class="nf-item-dock submit">Submit<span class="dashicons dashicons-dismiss"></span></span>
        </div>
    </section>
    <section class="nf-settings nf-favorites">
        <h3>Saved Fields</h3>
        <div class="nf-one-third">
            <div class="nf-item first-name-tr">First Name</div>
        </div>
        <div class="nf-one-third">
            <div class="nf-item last-name-tr">Last Name</div>
        </div>
        <div class="nf-one-third">
            <div class="nf-item email-tr">Email</div>
        </div>
        <div class="nf-one-third">
            <div class="nf-item submit-tr">Submit</div>
        </div>
    </section>
    <section class="nf-settings">
        <h3>Common Fields</h3>
        <div class="nf-one-third">
            <div class="nf-item">Textbox</div>
        </div>
        <div class="nf-one-third">
            <div class="nf-item textarea-tr">Textarea</div>
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
</script>

