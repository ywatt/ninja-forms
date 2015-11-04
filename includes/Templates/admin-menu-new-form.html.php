<div id="nf-builder" class="grey"></div>

<script id="nf-tmpl-builder" type="text/template">
    <div id="nf-header"></div>
    <div id="nf-main" class="nf-app-main"></div>
    <!-- <div id="nf-menu-drawer"></div> -->
    <div id="nf-drawer"></div>
</script>

<script id="nf-tmpl-header" type="text/template">
    <div id="nf-app-header"></div>
    <h2><%= renderTitle() %></h2>
    <div id="nf-app-sub-header"></div>

</script>

<script id="nf-tmpl-sub-header-fields" type="text/template">
    <a class="nf-add-new nf-open-drawer" href="#" data-drawerid="addField">Add new field</a>
</script>

<script id="nf-tmpl-sub-header-actions" type="text/template">
    <a class="nf-add-new nf-open-drawer" href="#" data-drawerid="addAction">Add new action</a>
</script>

<script id="nf-tmpl-sub-header-settings" type="text/template">

</script>

<script id="nf-tmpl-app-header" type="text/template">
    <div id="nf-logo"></div>
    <ul class="nf-app-menu"></ul>
    <a class="nf-mobile" href="#"><span class="dashicons dashicons-editor-ul"></span></a>
    <span class="nf-app-buttons"></span>
</script>

<script id="nf-tmpl-app-header-action-button" type="text/template">
    <input class="nf-button primary <%= maybeDisabled() %> publish" type="submit" value="Publish" />
    <%= maybeRenderCancel() %>
</script>

<script id="nf-tmpl-app-header-cancel" type="text/template">
    <a class="nf-cancel cancel" style="text-decoration: none;" href="#"><span class="dashicons dashicons-backup"></span></a>
</script>

<script id="nf-tmpl-main" type="text/template">
    <div id="nf-main-header" class="nf-app-area"></div>
    <div id="nf-main-content" class="nf-app-area"></div>
</script>

<script id="nf-tmpl-main-header-fields" type="text/template">
    <input class="nf-button secondary nf-change-domain" data-domain="actions" type="button" value="Edit Emails and Actions" />
</script>

<script id="nf-tmpl-main-header-actions" type="text/template">
    <input class="nf-button secondary nf-change-domain" data-domain="settings" type="button" value="Manage Settings" />
</script>

<script id="nf-tmpl-main-header-settings" type="text/template">

</script>

<script id="nf-tmpl-main-content-fields-empty" type="text/template">
    <div class="nf-fields-empty">
        <h3>Add form fields</h3>
        <p>Get started by adding your first form field. Just click the plus and select the fields you want. It’s that easy.</p>
    </div>
</script>

<script id="nf-tmpl-main-content-field" type="text/template">
    <div id="<%= getFieldID() %>" class="nf-field-wrap"> <%= label %>
        <ul class="nf-item-controls">
            <li class="nf-item-delete"><a href="#"><span class="nf-delete dashicons dashicons-dismiss"></span><span class="nf-tooltip">Delete</span></a></li>
            <li class="nf-item-duplicate"><a href="#"><span class="nf-duplicate dashicons dashicons-admin-page"></span><span class="nf-tooltip">Duplicate</span></a></li>
            <li class="nf-item-edit"><a href="#"><span class="nf-edit-settings dashicons dashicons-admin-generic" data-drawerid="editField"></span><span class="nf-tooltip">Edit</span><span class="nf-item-editing">Editing field</span></a></li>
        </ul>
    </div>
</script>

<script id="nf-tmpl-actions" type="text/template">
    <table id="nf-table-display" class="nf-actions-table">
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
                <td>
                    <ul class="nf-item-controls">
                        <li class="nf-item-delete"><a href="#"><span class="dashicons dashicons-dismiss"></span><span class="nf-tooltip">Delete</span></a></li>
                        <li class="nf-item-duplicate"><a href="#"><span class="dashicons dashicons-admin-page"></span><span class="nf-tooltip">Duplicate</span></a></li>
                        <li class="nf-item-edit"><a href="#"><span class="nf-open-drawer dashicons dashicons-admin-generic" data-drawerid="editAction"></span><span class="nf-tooltip">Edit</span><span class="nf-item-editing">Editing field</span></a></li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" class="nf-toggle" checked /></td>
                <td>Email to Admin</td>
                <td>Email</td>
                <td>
                    <ul class="nf-item-controls">
                        <li class="nf-item-delete"><a href="#"><span class="dashicons dashicons-dismiss"></span><span class="nf-tooltip">Delete</span></a></li>
                        <li class="nf-item-duplicate"><a href="#"><span class="dashicons dashicons-admin-page"></span><span class="nf-tooltip">Duplicate</span></a></li>
                        <li class="nf-item-edit"><a href="#"><span class="nf-open-drawer dashicons dashicons-admin-generic" data-drawerid="editAction"></span><span class="nf-tooltip">Edit</span><span class="nf-item-editing">Editing field</span></a></li>
                    </ul>
                </td>
            </tr>
            <tr class="nf-deactivated">
                <td><input type="checkbox" class="nf-toggle" /></td>
                <td>Thank You Message</td>
                <td>Sucess Message</td>
                <td>
                    <ul class="nf-item-controls">
                        <li class="nf-item-delete"><a href="#"><span class="dashicons dashicons-dismiss"></span><span class="nf-tooltip">Delete</span></a></li>
                        <li class="nf-item-duplicate"><a href="#"><span class="dashicons dashicons-admin-page"></span><span class="nf-tooltip">Duplicate</span></a></li>
                        <li class="nf-item-edit"><a href="#"><span class="nf-open-drawer dashicons dashicons-admin-generic" data-drawerid="editAction"></span><span class="nf-tooltip">Edit</span><span class="nf-item-editing">Editing field</span></a></li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
</script>

<script id="nf-tmpl-settings" type="text/template">
    <div class="nf-setting-wrap"><span class="nf-open-drawer" data-drawerid="editFormSettings">Display Settings</span></div>
    <div class="nf-setting-wrap"><span class="nf-open-drawer" data-drawerid="editFormSettings">Restrictions</span></div>
    <div class="nf-setting-wrap"><span class="nf-open-drawer" data-drawerid="editFormSettings">Calculations</span></div>
    <div class="nf-setting-wrap"><span class="nf-open-drawer" data-drawerid="editFormSettings">PayPal</span></div>
    <div class="nf-setting-wrap"><span class="nf-open-drawer" data-drawerid="editFormSettings">Stripe</span></div>
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
    <div id="nf-drawer-header"></div>
    <span id="nf-drawer-content"></span>
    <a class="nf-toggle-drawer">
        <span class="dashicons dashicons-admin-collapse"></span><span class="nf-expand-off">Full screen</span><span class="nf-expand-on">Half screen</span>
    </a>
</script>

<script id="nf-tmpl-drawer-content-add-field" type="text/template">
    <section id="nf-drawer-staging" class="nf-settings nf-stage">
        <div class="nf-reservoir nf-drawer-staged-fields nf-field-type-droppable"></div>
    </section>
    <span id="nf-drawer-primary"></span>
    <span id="nf-drawer-secondary"></span>
</script>

<script id="nf-tmpl-drawer-content-add-action" type="text/template">
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
</script>

<script id="nf-tmpl-drawer-content-view-changes-item" type="text/template">
    <%
    /*
    for ( var prop in before ) {
        var setting = prop;
    }

    if ( 'undefined' !== typeof setting ) {
    %>
    <ul>
        <li>
            <span class="dashicons dashicons-admin-generic"></span> Field <%= object.get( 'id' ) %> - <%= setting %> changed from '<%= before[setting] %>' to '<%= after[setting] %>'
        </li>
    </ul>
    <%       
    }
    */
    %>
</script>

<script id="nf-tmpl-drawer-content-edit-field" type="text/template">
    <h2><span class="dashicons dashicons-star-empty"></span> <%= label %></h2>
    <span class="nf-settings-groups"></span>
</script>

<script id="nf-tmpl-drawer-content-edit-field-setting-group" type="text/template">
    <section class="nf-settings">
        <%= renderLabel() %>
        <span class="nf-field-settings"></span>
    </section>
</script>

<script id="nf-tmpl-drawer-content-edit-field-setting-group-label" type="text/template">
    <h3 class="toggle"><span class="dashicons dashicons-arrow-<%= renderArrowDir() %>"></span><%= name %></h3>
</script>

<script id="nf-tmpl-drawer-content-edit-action" type="text/template">
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
        <fieldset class="nf-wp-editor">
            <legend>Email Message</legend>
            <div class="nf-full">

            </div>
            <div class="nf-full">
                <?php //wp_editor( 'Your Email Message', 2, $settings = array() ); ?>
            </div>
        </fieldset>
    </section>
</script>

<script id="nf-tmpl-drawer-content-edit-form-settings" type="text/template">
    <section class="nf-settings">
        <div class="nf-full toggle-row">
            <label>Display Form Title</label>
            <input type="checkbox" class="nf-toggle" />
        </div>
        <div class="nf-full toggle-row">
            <label>Clear form values after successful submission kjh hkja askh askjh jkasfhj kjhasf</label>
            <input type="checkbox" class="nf-toggle" />
        </div>
        <div class="nf-full toggle-row">
            <label>Hide form after successful submission</label>
            <input type="checkbox" class="nf-toggle" />
        </div>
    </section>
</script>

<script id="nf-tmpl-drawer-staged-field" type="text/template">
     <span class="nf-item-dock" id="<%= id %>" data-id="<%= slug %>"><%= nicename %><span class="dashicons dashicons-dismiss"></span>
</script>

<script id="nf-tmpl-drawer-field-type-section" type="text/template">
    <section class="nf-settings <%= classes %>">
        <h3><%= nicename %></h3>
        <%= renderFieldTypes() %>
    </section>
</script>

<script id="nf-tmpl-drawer-field-type-button" type="text/template">
    <div class="nf-field-type-button nf-one-third <%= savedField() %>" data-id="<%= id %>">
        <div class="nf-item" data-id="<%= id %>" tabindex="0"><%= nicename %></div>
    </div>
</script>

<script id="nf-tmpl-drawer-header-default" type="text/template">
    <header class="nf-drawer-header">
        <div class="nf-search">
            <input type="search" class="nf-filter" value="" placeholder="Filter" tabindex="-1" />
        </div>
        <a href="#" class="nf-button primary nf-close-drawer" tabindex="-1">Done</a>
    </header>
</script>

<script id="nf-tmpl-drawer-header-view-changes" type="text/template">
    <header class="nf-drawer-header">
        <div>
            <a href="#" class="nf-button secondary cancelChanges" style="float:left;" tabindex="-1"><span class="dashicons dashicons-backup"></span> Undo All</a>
        </div>
        <a href="#" class="nf-button primary nf-close-drawer" tabindex="-1">Done</a>
    </header>
</script>

<script id="nf-tmpl-app-menu-item" type="text/template">
    <li><a href="<%= renderUrl() %>" class="<%= renderClasses() %>" target="<%= renderTarget() %>" <%= renderDisabled() %>><%= nicename %><%= renderDashicons() %></a></li>
</script>

<div class="nf-field-wrap nf-field-hover hidden">
    <ul class="nf-item-controls">
        <li class="nf-item-delete"><a href="#"><span class="dashicons dashicons-dismiss"></span><span class="nf-tooltip">Delete</span></a></li>
        <li class="nf-item-duplicate"><a href="#"><span class="dashicons dashicons-admin-page"></span><span class="nf-tooltip">Duplicate</span></a></li>
        <li class="nf-item-edit"><a href="#"><span class="nf-open-drawer dashicons dashicons-admin-generic" data-drawerid="editField"></span><span class="nf-tooltip">Edit</span><span class="nf-item-editing">Editing field</span></a></li>
    </ul>
</div>

<script id="nf-tmpl-staged-fields-drag" type="text/template">
    <div class="nf-staged-fields-drag">
        <div id="drag-item-1" class="nf-field-wrap"><%= num %> Fields</div>
        <div id="drag-item-2" class="nf-field-wrap">&nbsp;</div>
        <div id="drag-item-3" class="nf-field-wrap">&nbsp;</div>
    </div>
</script>

<script id="nf-tmpl-drawer-staged-fields-empty" type="text/template">
    <span></span>
</script>

<script id="nf-tmpl-drawer-content-empty" type="text/template">

</script>



<!-- Field Settings Templates -->

<script id="nf-tmpl-edit-field-setting-wrap" type="text/template">
    <div class="nf-<%= renderWidth() %>">
        <%= renderSetting() %>
    </div>
</script>

<script id="nf-tmpl-edit-field-setting-textbox" type="text/template">
    <%= renderLabel() %>
    <input type="text" value="<%= value %>" placeholder="<%= placeholder %>" />
</script>

<script id="nf-tmpl-edit-field-setting-textarea" type="text/template">
    <%= renderLabel() %>
    <textarea><%= value %></textarea>
</script>

<script id="nf-tmpl-edit-field-setting-dropdown" type="text/template">
    <%= renderLabel() %>
    <div class="nf-select">
        <select>
            <%
            _.each( options, function( option ) {
                %>
                <option value="<%= option.value %>" <%= ( value == option.value ) ? 'selected="selected"' : '' %>><%= option.label %></option>
                <%
            } );
            %>
        </select>
    </div>
</script>

<script id="nf-tmpl-edit-field-setting-toggle" type="text/template">
    <label><%= renderLabel() %></label>
    <input type="checkbox" class="nf-toggle" <%= ( 1 == value ) ? 'checked' : '' %> />
</script>

<script id="nf-tmpl-edit-field-setting-fieldset" type="text/template">
    <fieldset>
        <legend><%= label %></legend>
        <span class="nf-field-sub-settings"></span>
    </fieldset>
</script>

<script id="nf-tmpl-edit-field-setting-list-repeater" type="text/template">
    <fieldset class="nf-list-options">
        <legend><%= label %></legend>
        <div class="nf-div-table">
            <div class="nf-table-row nf-table-header">
                <div>&nbsp;</div>
                <div>Label</div>
                <div>Value</div>
                <div>Calc Value</div>
                <div><span class="dashicons dashicons-yes"></span></div>
                <div>&nbsp;</div>
            </div>

            <div class="nf-list-options-tbody">
            </div>
        </div>
    </fieldset>
</script>

<script id="nf-tmpl-edit-field-setting-list-empty" type="text/template">

</script>

<script id="nf-tmpl-edit-field-setting-list-option" type="text/template">
    <div>
        <span class="dashicons dashicons-menu handle"></span>
    </div>
    <div>
        <input type="text" value="<%= label %>" data-id="label">
    </div>
    <div>
        <input type="text" value="<%= value %>" data-id="value">
    </div>
    <div>
        <input type="text" value="<%= calc %>" data-id="calc">
    </div>
    <div>
        <input type="checkbox" value="1" data-id="selected">
    </div>
    <div>
        <span class="dashicons dashicons-dismiss nf-delete"></span>
    </div>
</script>
