<div id="nf-builder" class="grey nf-drawer-closed"></div>

<script id="nf-tmpl-builder" type="text/template">
    <div id="nf-header"></div>
    <div id="nf-main"></div>
    <div id="nf-menu-drawer"></div>
    <div id="nf-drawer"></div>
</script>

<script id="nf-tmpl-header" type="text/template">
    <div id="nf-app-header"></div>

    <div id="nf-app-sub-header">
        <a class="nf-add-new nf-open-drawer" href="#">Add new field</a>
        <h2>Contact Form</h2>
    </div>
</script>

<script id="nf-tmpl-app-header" type="text/template">
    <div id="nf-logo"></div>
    <ul class="nf-app-menu"></ul>
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
        <li><a href="#" tabindex="-1"><span class="dashicons dashicons-menu"></span>Form Fields</a></li>
        <li><a href="http://three.ninjaforms.com/wp-admin/admin.php?page=edit-action" tabindex="-1"><span class="dashicons dashicons-external"></span>Emails & Actions</a></li>
        <li><a href="#" tabindex="-1"><span class="dashicons dashicons-admin-generic"></span>Settings</a></li>
        <li><a href="#" tabindex="-1"><span class="dashicons dashicons-visibility"></span>Preview</a></li>
    </ul>
</script>

<script id="nf-tmpl-drawer" type="text/template">
    <!-- drawer area. This is where settings and add fields are rendered. -->
    <!-- THIS IS THE CONTENT FOR EDITING FIELDS -->
    <div id="nf-drawer-header"></div>
    <section id="nf-drawer-staging" class="nf-settings nf-stage">
        <div class="nf-reservoir"></div>
    </section>
    <span id="nf-drawer-primary"></span>
    <span id="nf-drawer-secondary"></span>
    <a class="nf-toggle-drawer">
        <span class="dashicons dashicons-admin-collapse"></span><span class="nf-expand-off">Full screen</span><span class="nf-expand-on">Half screen</span>
    </a>
</script>

<script id="nf-tmpl-drawer-staged-field" type="text/template">
     <span class="nf-item-dock" id="nf-staged-field-<%= slug %>"><%= nicename %><span class="dashicons dashicons-dismiss"></span>
</script>

<script id="nf-tmpl-drawer-field-type-section" type="text/template">
    <section class="nf-settings <%= classes %>">
        <h3><%= nicename %></h3>
        <%= renderFieldTypes() %>
    </section>
</script>

<script id="nf-tmpl-drawer-field-type-button" type="text/template">
    <div class="nf-one-third <%= savedField() %>">
        <div class="nf-item" data-id="<%= id %>" tabindex="0"><%= nicename %></div>
    </div>
</script>

<script id="nf-tmpl-drawer-header" type="text/template">
    <header class="nf-drawer-header">
        <div class="nf-search">
            <input type="search" class="nf-type-filter" value="" placeholder="Filter" />
        </div>
        <a href="#" class="nf-button primary nf-close-drawer" tabindex="99">Done</a>
    </header>
</script>

<script id="nf-tmpl-app-menu-item" type="text/template">
    <li><a href="#" class="<%= classes %>"><%= nicename %><%= renderDashicons() %></a></li>
</script>
