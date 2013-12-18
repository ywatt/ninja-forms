<?php

function ninja_forms_add_menu(){
	$plugins_url = plugins_url();

	if ( isset ( $_REQUEST['page'] ) and $_REQUEST['page'] == 'ninja-forms-edit' and isset ( $_REQUEST['form_id'] ) ) {
		$edit_form_parent = 'ninja-forms';
	} else {
		$edit_form_parent = null;
	}

	$capabilities = 'manage_options';
	$capabilities = apply_filters( 'ninja_forms_admin_menu_capabilities', $capabilities );

	$page = add_menu_page("Ninja Forms" , __( 'Forms', 'ninja-forms' ), $capabilities, "ninja-forms", null, NINJA_FORMS_URL."/images/ninja-head-ico-small.png" );

	$all_forms = add_submenu_page("ninja-forms", __( 'Forms', 'ninja-forms' ), __( 'All Forms', 'ninja-forms' ), $capabilities, "ninja-forms", "ninja_forms_admin_all_forms");
	$new_form = add_submenu_page("ninja-forms", __( 'Add New', 'ninja-forms' ), __( 'Add New', 'ninja-forms' ), $capabilities, "ninja-forms&form_id=new", "ninja_forms_admin_all_forms");
	$edit_form = add_submenu_page( $edit_form_parent, __( 'Edit Form', 'ninja-forms' ), __( 'Edit Form', 'ninja-forms' ), $capabilities, "ninja-forms-edit", "ninja_forms_admin_edit_form");
	/*

	$subs = add_submenu_page("ninja-forms", __( 'Submissions', 'ninja-forms' ), __( 'Submissions', 'ninja-forms' ), $capabilities, "ninja-forms-subs", "ninja_forms_admin");
	$import = add_submenu_page("ninja-forms", __( 'Import/Export', 'ninja-forms' ), __( 'Import / Export', 'ninja-forms' ), $capabilities, "ninja-forms-impexp", "ninja_forms_admin");
	$settings = add_submenu_page("ninja-forms", __( 'Ninja Form Settings', 'ninja-forms' ), __( 'Settings', 'ninja-forms' ), $capabilities, "ninja-forms-settings", "ninja_forms_admin");
	$system_status = add_submenu_page("ninja-forms", __( 'System Status', 'ninja-forms' ), __( 'System Status', 'ninja-forms' ), $capabilities, "ninja-forms-system-status", "ninja_forms_admin");
	$extend = add_submenu_page("ninja-forms", __( 'Ninja Form Extensions', 'ninja-forms' ), __( 'Extend', 'ninja-forms' ), $capabilities, "ninja-forms-extend", "ninja_forms_admin");
	*/
	add_action('admin_print_styles-' . $page, 'ninja_forms_admin_css');
	add_action('admin_print_styles-' . $page, 'ninja_forms_admin_js');

	add_action('admin_print_styles-' . $all_forms, 'ninja_forms_admin_css');
	add_action('admin_print_styles-' . $all_forms, 'ninja_forms_admin_js');

	add_action('admin_print_styles-' . $edit_form, 'ninja_forms_admin_css');
	add_action('admin_print_styles-' . $edit_form, 'ninja_forms_admin_js');
	/*
	add_action('admin_print_styles-' . $settings, 'ninja_forms_admin_js');
	add_action('admin_print_styles-' . $settings, 'ninja_forms_admin_css');

	add_action('admin_print_styles-' . $import, 'ninja_forms_admin_js');
	add_action('admin_print_styles-' . $import, 'ninja_forms_admin_css');

	add_action('admin_print_styles-' . $subs, 'ninja_forms_admin_js');
	add_action('admin_print_styles-' . $subs, 'ninja_forms_admin_css');

	add_action('admin_print_styles-' . $system_status, 'ninja_forms_admin_js');
	add_action('admin_print_styles-' . $system_status, 'ninja_forms_admin_css');

	add_action('admin_print_styles-' . $extend, 'ninja_forms_admin_js');
	add_action('admin_print_styles-' . $extend, 'ninja_forms_admin_css');

	add_action( 'load-' . $page, 'ninja_forms_load_screen_options_tab' );
	//add_action( 'load-' . $all_forms, 'ninja_forms_load_screen_options_tab' );
	add_action( 'load-' . $settings, 'ninja_forms_load_screen_options_tab' );
	add_action( 'load-' . $import, 'ninja_forms_load_screen_options_tab' );
	add_action( 'load-' . $subs, 'ninja_forms_load_screen_options_tab' );
	add_action( 'load-' . $system_status, 'ninja_forms_load_screen_options_tab' );
	add_action( 'load-' . $extend, 'ninja_forms_load_screen_options_tab' );
	*/
}

add_action( 'admin_menu', 'ninja_forms_add_menu' );

function ninja_forms_admin_edit_form(){
	global $wpdb, $ninja_forms_form_settings_tabs;

	do_action( 'ninja_forms_admin_init' );

	if ( isset ( $_REQUEST['form_id'] ) ) {
		$form_id = $_REQUEST['form_id'];
	} else {
		$form_id = '';
	}

	if ( $form_id != '' ) {
		$form_row = ninja_forms_get_form_by_id( $form_id );
	}

	if ( isset ( $form_row['data'] ) ) {
		$form_data = $form_row['data'];
	} else {
		$form_data = '';
	}

	$high_priority_tabs = array();
	$core_priority_tabs = array();
	$default_priority_tabs = array();
	$low_priority_tabs = array();

	foreach ( $ninja_forms_form_settings_tabs as $tab => $data ) {
		$priority = $data['priority'];
		if ( $priority == 'high' ) {
			$high_priority_tabs[$tab] = $data;
		} else if ( $priority == 'core' ) {
			$core_priority_tabs[$tab] = $data;
		} else if ( $priority == 'default' ) {
			$default_priority_tabs[$tab] = $data;
		} else if ( $priority == 'low' ) {
			$low_priority_tabs[$tab] = $data;
		}
	}

	?>

	<div id="icon-ninja-custom-forms" class="icon32"><br></div>
	<h2>Form Editor - <?php if ( isset ( $form_data['form_title'] ) ) echo $form_data['form_title'];?> - ID : <?php echo $form_id;?></h2>

	<div id="nav-menus-frame">
	<div id="menu-settings-column" class="metabox-holder">

		<div class="clear"></div>

		<div id="side-sortables" class="accordion-container">

			<ul class="outer-border">

				<li class="control-section accordion-section  open add-page top" id="add-page">
					<h3 class="accordion-section-title hndle" tabindex="0" title="Pages">General Fields</h3>
					<div class="accordion-section-content ">
						<div class="inside">
							<div class="button button-secondary ninja-forms-field-button">Single Line Text</div>
							<div class="button button-secondary ninja-forms-field-button">Multi Line Text</div>
							<div class="button button-secondary ninja-forms-field-button">Checkbox</div>
							<div class="button button-secondary ninja-forms-field-button">Dropdown List</div>
						</div><!-- .inside -->
					</div><!-- .accordion-section-content -->
				</li><!-- .accordion-section -->

				<li class="control-section accordion-section   add-custom-links" id="add-custom-links">
					<h3 class="accordion-section-title hndle" tabindex="0" title="Links">Advanced Fields</h3>
					<div class="accordion-section-content ">
						<div class="inside">
						</div><!-- .inside -->
					</div><!-- .accordion-section-content -->
				</li><!-- .accordion-section -->

				<li class="control-section accordion-section   add-category" id="add-category">
					<h3 class="accordion-section-title hndle" tabindex="0" title="Categories">Calculation Fields</h3>
					<div class="accordion-section-content ">
						<div class="inside">
						</div><!-- .inside -->
					</div><!-- .accordion-section-content -->
				</li><!-- .accordion-section -->

				<li class="control-section accordion-section   add-post_format bottom" id="add-post_format">
					<h3 class="accordion-section-title hndle" tabindex="0" title="Format">Layout Elements</h3>
					<div class="accordion-section-content  bottom">
						<div class="inside">
						</div><!-- .inside -->
					</div><!-- .accordion-section-content -->
				</li><!-- .accordion-section -->

			</ul><!-- .outer-border -->
		</div><!-- .accordion-container -->
	</div><!-- /#menu-settings-column -->

	<div id="menu-management-liquid">
		<div id="menu-management">
			<div class="menu-edit ">
				<div id="nav-menu-header">
					<div class="major-publishing-actions">
						<div class="publishing-action">
							<a href="#ex1" rel="modal:open"><input type="button" id="form_settings" class="open-settings-modal button button-secondary" value="Form Settings"></a>
						</div><!-- END .publishing-action -->
					</div><!-- END .major-publishing-actions -->
				</div><!-- END .nav-menu-header -->
				<div id="post-body">
					<div id="post-body-content">
						<h3>Forms Structure</h3>
						<p>Drag each item into the order you prefer. Click edit to reveal additional options.</p>
						<ul class="ninja-row ninja-drop" data-cols="0" style="padding:10px;" id="1">

						</ul>
						<ul class="ninja-row ninja-drop" data-cols="1" style="padding:2px;" id="2">
							<li class="ninja-col-1-1" data-size="1-1" id="4x4">
								<div class="ninja-forms-admin-field label-above open-settings-modal">
									<label>First Name</label>
									<input type="text" disabled />
									<div class="nf-footer-left">
										<a href="#" class="open-settings-modal">Edit</a>
									</div>
									<div class="nf-footer-right">
										Single Line Text - ID : 1
									</div>
								</div>
							</li>
						</ul>
						<ul class="ninja-row ninja-drop" data-cols="0" style="padding:10px;" id="3">

						</ul>
						<ul class="ninja-row ninja-drop" data-cols="2" style="padding:2px;">
							<li class="ninja-col-1-2" data-size="1-2" id="1 - 2x4">
								<div class="ninja-forms-admin-field label-above open-settings-modal">
									<label>Last Name</label>
									<input type="text" disabled />
									<div class="nf-footer-left">
										<a href="#" class="open-settings-modal">Edit</a>
									</div>
									<div class="nf-footer-right">
										Single Line Text - ID : 2
									</div>
								</div>
								<div class="nf-right-handlebar"></div>
							</li>

							<li class="ninja-col-1-2" data-size="1-2" id="2 - 2x4">
								<div class="ninja-forms-admin-field label-above">
									<div class="nf-left-handlebar"></div>
									<label>Email Address</label>
									<input type="text" disabled />
									<div class="nf-footer-left">
										<a href="#" class="open-settings-modal">Edit</a>
									</div>
									<div class="nf-footer-right">
										Single Line Text - ID : 3
									</div>
								</div>
							</li>
						</ul>
						<ul class="ninja-row ninja-drop" data-cols="0" style="padding:10px;">

						</ul>
						<ul class="ninja-row ninja-drop" data-cols="3" style="padding:2px;">
							<li class="ninja-col-1-3" data-size="1-3" id="1 - 1x3">
								<div class="ninja-forms-admin-field label-above">
									<label>Phone Number</label>
									<input type="text" disabled />
									<div class="nf-footer-left">
										<a href="#" class="open-settings-modal">Edit</a>
									</div>
									<div class="nf-footer-right">
										Single Line Text - ID : 4
									</div>
								</div>
								<div class="nf-right-handlebar"></div>
							</li>

							<li class="ninja-col-1-3" data-size="1-3" id="2 - 1x3">
								<div class="nf-left-handlebar"></div>
								<div class="ninja-forms-admin-field label-above">
									<label>Address 1</label>
									<input type="text" disabled />
									<div class="nf-footer-left">
										<a href="#" class="open-settings-modal">Edit</a>
									</div>
									<div class="nf-footer-right">
										Single Line Text - ID : 5
									</div>
								</div>
								<div class="nf-right-handlebar"></div>
							</li>

							<li class="ninja-col-1-3" data-size="1-3" id="3 - 1x3">
								<div class="nf-left-handlebar"></div>
								<div class="ninja-forms-admin-field label-above">
									<label>Address 2</label>
									<input type="text" disabled />
									<div class="nf-footer-left">
										<a href="#" class="open-settings-modal">Edit</a>
									</div>
									<div class="nf-footer-right">
										Single Line Text - ID : 6
									</div>
								</div>
							</li>
						</ul>
						<ul class="ninja-row ninja-drop" data-cols="0" style="padding:10px;">

						</ul>
						<ul class="ninja-row" data-cols="4" style="padding:2px;">
							<li class="ninja-col-1-4" data-size="1-4" id="1 - 1x4">
								<div class="ninja-forms-admin-field label-above">
									<label>City</label>
									<input type="text" disabled />
									<div class="nf-footer-left">
										<a href="#" class="open-settings-modal">Edit</a>
									</div>
									<div class="nf-footer-right">
										Single Line Text - ID : 7
									</div>
								</div>
							</li>

							<li class="ninja-col-1-4" data-size="1-4" id="2 - 1x4">
								<div class="ninja-forms-admin-field label-above">
									<label>State</label>
									<input type="text" disabled />
									<div class="nf-footer-left">
										<a href="#" class="open-settings-modal">Edit</a>
									</div>
									<div class="nf-footer-right">
										Single Line Text - ID : 8
									</div>
								</div>
							</li>

							<li class="ninja-col-1-4" data-size="1-4" id="3 - 1x4">
								<div class="ninja-forms-admin-field label-above">
									<label>Zip</label>
									<input type="text" disabled />
									<div class="nf-footer-left">
										<a href="#" class="open-settings-modal">Edit</a>
									</div>
									<div class="nf-footer-right">
										Single Line Text - ID : 9
									</div>
								</div>
							</li>

							<li class="ninja-col-1-4" data-size="1-4" id="4 - 1x4">
								<div class="ninja-forms-admin-field label-above">
									<label>Country</label>
									<input type="text" disabled />
									<div class="nf-footer-left">
										<a href="#" class="open-settings-modal">Edit</a>
									</div>
									<div class="nf-footer-right">
										Single Line Text - ID : 10
									</div>
								</div>
							</li>
						</ul>
						<ul class="ninja-row ninja-drop" data-cols="0" style="padding:10px;">

						</ul>
						<!-- <ul class="ninja-row">
							<li class="ninja-col-1-3" data-size="1-3">
								<div class="ninja-forms-admin-field label-above open-settings-modal">
									<label>Label</label>
									<input type="text" disabled />
									<div class="nf-footer-left">
										<a href="#" class="open-settings-modal">Edit</a>
									</div>
									<div class="nf-footer-right">
										Single Line Text - ID : 20
									</div>
								</div>
								<div class="nf-right-handlebar"></div>
							</li>
							<li class="ninja-col-2-3" data-size="2-3">
								<div class="ninja-forms-admin-group label-above">
									<div class="nf-left-handlebar"></div>
									<label>Contact Info</label>

									<div class="ninja-forms-admin-field label-above open-settings-modal">
										<label>Label</label>
										<input type="text" disabled />
										<div class="nf-footer-left">
											<a href="#" class="open-settings-modal">Edit</a>
										</div>
										<div class="nf-footer-right">
											Single Line Text - ID : 20
										</div>
									</div>

									<div class="ninja-forms-admin-field label-above open-settings-modal">
										<label>Label</label>
										<input type="text" disabled />
										<div class="nf-footer-left">
											<a href="#" class="open-settings-modal">Edit</a>
										</div>
										<div class="nf-footer-right">
											Single Line Text - ID : 20
										</div>
									</div>

									<div class="nf-footer-left">
										<a href="#" class="open-settings-modal">Edit</a>
									</div>
									<div class="nf-footer-right">
										Group - ID : 20
									</div>
								</div>
							</li>

						</ul>-->

						<ul class="ninja-row ninja-drop" data-cols="2" style="padding:2px;">
							<li class="ninja-col-1-2" data-size="1-2">
								<div class="ninja-forms-admin-field label-above open-settings-modal">
									<label>Profile Name</label>
									<input type="text" disabled />
									<div class="nf-footer-left">
										<a href="#" class="open-settings-modal">Edit</a>
									</div>
									<div class="nf-footer-right">
										Single Line Text - ID : 20
									</div>
								</div>
								<div class="nf-right-handlebar"></div>
							</li>

							<li class="ninja-col-1-2" data-size="1-2">
								<div class="ninja-forms-admin-field label-above">
									<div class="nf-left-handlebar"></div>
									<label>Website</label>
									<input type="text" disabled />
									<div class="nf-footer-left">
										<a href="#" class="open-settings-modal">Edit</a>
									</div>
									<div class="nf-footer-right">
										Single Line Text - ID : 20
									</div>
								</div>
							</li>
						</ul>
						<ul class="ninja-row ninja-drop" data-cols="0" style="padding:10px;">

						</ul>

					</div><!-- /#post-body-content -->
				</div><!-- /#post-body -->
				<div id="nav-menu-footer">
					<div class="major-publishing-actions">
						<div class="publishing-action">
							<a class="submitdelete deletion menu-delete" href="/wp-admin/nav-menus.php?action=delete&amp;menu=6&amp;0=http%3A%2F%2Fnf.com%2Fwp-admin%2F&amp;_wpnonce=27e3bc67f9">Delete Form</a>
						</div><!-- END .publishing-action -->
					</div><!-- END .major-publishing-actions -->
				</div><!-- /#nav-menu-footer -->
			</div><!-- /.menu-edit -->
		</div><!-- /#menu-management -->
	</div><!-- /#menu-management-liquid -->
	</div>

  <div id="ex1" style="display:none;">
  	<a class="media-modal-close" href="#" title="Close">
  		<span class="media-modal-icon"></span>
  	</a>
  	<div class="media-frame wp-core-ui" id="__wp-uploader-id-0">

		<div class="media-frame-menu">
			<div class="media-menu">

				<?php
				if ( is_array( $high_priority_tabs ) and !empty( $high_priority_tabs ) ) {
					?>
					<div class="separator"></div>
					<?php
				}
				$active = false;
				foreach( $high_priority_tabs as $tab => $settings ){
					if ( isset ( $settings['class'] ) ) {
						$class = $settings['class'];
					} else {
						$class = '';
					}
					if ( isset ( $settings['desc'] ) ) {
						$desc = $settings['desc'];
					} else {
						$desc = '';
					}
					if ( !$active ) {
						$class .= ' active';
						$active = true;
					}
				?>
				<a href="#<?php echo $tab;?>" class="media-menu-item <?php echo $class; ?>" id="<?php echo $tab; ?>"><?php echo $settings['label']; ?></a>
				<?php
				}
				if ( is_array( $high_priority_tabs ) and !empty( $high_priority_tabs ) and is_array( $core_priority_tabs ) and !empty( $core_priority_tabs ) ) {
					?>
					<div class="separator"></div>
					<?php
				}

				foreach( $core_priority_tabs as $tab => $settings ){
					if ( isset ( $settings['class'] ) ) {
						$class = $settings['class'];
					} else {
						$class = '';
					}
					if ( isset ( $settings['desc'] ) ) {
						$desc = $settings['desc'];
					} else {
						$desc = '';
					}
					if ( !$active ) {
						$class .= ' active';
						$active = true;
					}
				?>
				<a href="#<?php echo $tab;?>" class="media-menu-item <?php echo $class; ?>" id="<?php echo $tab; ?>" title="<?php echo $desc;?>"><?php echo $settings['label']; ?></a>
				<?php
				}

				if ( is_array( $core_priority_tabs ) and !empty( $core_priority_tabs ) and is_array( $default_priority_tabs ) and !empty( $default_priority_tabs ) ) {
					?>
					<div class="separator"></div>
					<?php
				}
				foreach( $default_priority_tabs as $tab => $settings ){
					if ( isset ( $settings['class'] ) ) {
						$class = $settings['class'];
					} else {
						$class = '';
					}
					if ( isset ( $settings['desc'] ) ) {
						$desc = $settings['desc'];
					} else {
						$desc = '';
					}
					if ( !$active ) {
						$class .= ' active';
						$active = true;
					}
				?>
				<a href="#<?php echo $tab;?>" class="media-menu-item <?php echo $class; ?>" id="<?php echo $tab; ?>" title="<?php echo $desc;?>"><?php echo $settings['label']; ?></a>
				<?php
				}

				if ( is_array( $default_priority_tabs ) and !empty( $default_priority_tabs ) and is_array( $low_priority_tabs ) and !empty ( $low_priority_tabs ) ) {
					?>
					<div class="separator"></div>
					<?php
				}
				foreach( $low_priority_tabs as $tab => $settings ){
					if ( isset ( $settings['class'] ) ) {
						$class = $settings['class'];
					} else {
						$class = '';
					}
					if ( isset ( $settings['desc'] ) ) {
						$desc = $settings['desc'];
					} else {
						$desc = '';
					}
					if ( !$active ) {
						$class .= ' active';
						$active = true;
					}
				?>
				<a href="#<?php echo $tab;?>" class="media-menu-item <?php echo $class; ?>" id="<?php echo $tab; ?>" title="<?php echo $desc;?>"><?php echo $settings['label']; ?></a>
				<?php
				}
				?>
			</div>
		</div>
		<div class="nf-settings">
			<div class="nf-settings-title">
				<h1></h1>
				<div class="updated" style="display:none"></div>
			</div>


			<div class="nf-settings-desc-desc"></div>

			<div class="nf-settings-content-wrap">
				<div class="nf-settings-content" id="my-content-id">

					<p>Place your settings here.</p>

				</div>
			</div>
		</div>
	</div>

  </div>
	<script type="text/html" id="tmpl-form-settings">
		<table class="form-table">
		<% _.each(settings, function(setting){
			var setting_id = setting.get( 'id' );
			var value = setting.get( 'current_value' );
			%>
			<tr class= "nf-<%= setting.get('type') %>">
			<%
			switch( setting.get('type') ) {

				case 'checkbox':
					%>
					<th>
						<label>
							<%= setting.get('label') %>
						</label>
					</th>
					<td>
						<input type="checkbox" id="<%= setting.id %>" class="<%= setting.get('class') %>" value="1" <% if ( value == 1 ) { %>checked<%}%>>
					</td>
					<%
					break;
				case 'select':
					%>
					<th>
						<label>
							<%= setting.get('label') %>
						</label>
					</th>
					<td>
						<select id="<%= setting_id %>" class="<%= setting.get('class') %>">
						<%
						_.each(setting.get('options'), function(option) {
							%>
							<option value="<%= option.value %>" <% if ( value == option.value ) { %> selected <% } %>><%= option.name %></option>
							<%
						});
						%>
						</select>
					</td>
					<%
					break;
				case 'textarea':
					%>
					<th colspan="2">
						<label>
							<%= setting.get('label') %>
						</label>
						<textarea id="<%= setting_id %>" class="<%= setting.get('class') %>"><%= value %></textarea>
					</th>
					<%
					break;
				case 'text':
					%>
					<th>
						<label>
							<%= setting.get('label') %>
						</label>
					</th>
					<td>
						<input type="text" id="<%= setting_id %>" class="<%= setting.get('class') %>" value="<%= value %>" />
					</td>
					<%
					break;
				case 'repeater-text':

					%>
					<label>
						<%= setting.get('label') %> <a href="#" id="<%= setting_id %>" class="repeater-add">Add New</a> <br />
					</label>
					<span id="<%= setting_id %>_span">
						<%
						if ( typeof value === 'object' ) {
							_.each(value, function(val) {
								%>
								<span>
									<input type="text" id="" class="<%= setting.get('class') %> repeater-<%= setting_id %> repeater-text" value="<%= val %>" data-group="<%= setting_id %>" /> - <a href="#" id="<%= setting_id %>" class="repeater-remove">X</a>
									<br />
								</span>
								<%
							});
						} else {
							%>
							<span>
								<input type="text" id="" class="<%= setting.get('class') %> repeater-<%= setting_id %> repeater-text" value="" data-group="<%= setting_id %>" /> - <a href="#" id="<%= setting_id %>" class="">X</a>
								<br />
							</span>
							<%
						}
						%>
						</span>
					<%
					break;
				case 'rte':
					%>
					<th class="nf-rte" colspan="2">
						<label>
							<%= setting.get('label') %>
						</label>
						<div id="<%= setting_id %>_replace"></div>
					</th>
					<%
					break;

			}
			%>
			<span class="howto">
				<%= setting.get('desc') %>
			</span>
		</tr>
		<% }); %>
		</table>
	</script>
	<div id="hidden_editor_div" class="hidden">
		<?php wp_editor( 'test', 'hidden_editor' ); ?>
	</div>
<?php

}

function ninja_forms_admin_body_filter( $classes ) {
	global $pagenow;

	if ( $pagenow == 'admin.php' and isset ( $_REQUEST['page'] ) ) {
		switch( $_REQUEST['page'] ) {
			case 'ninja-forms':
				$classes .= ' ninja-forms';
				$classes .= ' ninja-forms-forms';
				break;
			case 'ninja-forms-edit':
				$classes .= ' ninja-forms';
				$classes .= ' ninja-forms-edit';
				break;
			case 'ninja-forms-settings':
				$classes .= ' ninja-forms';
				$classes .= ' ninja-forms-settings';
				break;

		}

	}
	return $classes;
}

add_filter( 'admin_body_class', 'ninja_forms_admin_body_filter' );

function ninja_forms_get_current_tab(){
	global $ninja_forms_tabs;
	if(isset($_REQUEST['page'])){
		$current_page = $_REQUEST['page'];


		if(isset($_REQUEST['tab'])){
			$current_tab = $_REQUEST['tab'];
		}else{
			if(isset($ninja_forms_tabs[$current_page]) AND is_array($ninja_forms_tabs[$current_page])){
				$first_tab = array_slice($ninja_forms_tabs[$current_page], 0, 1);
				foreach($first_tab as $key => $val){
					$current_tab = $key;
				}
			}else{
				$current_tab = '';
			}
		}
		return $current_tab;
	}else{
		return false;
	}
}

function ninja_forms_date_to_datepicker($date){
	$pattern = array(

		//day
		'd',		//day of the month
		'j',		//3 letter name of the day
		'l',		//full name of the day
		'z',		//day of the year

		//month
		'F',		//Month name full
		'M',		//Month name short
		'n',		//numeric month no leading zeros
		'm',		//numeric month leading zeros

		//year
		'Y', 		//full numeric year
		'y'		//numeric year: 2 digit
	);
	$replace = array(
		'dd','d','DD','o',
		'MM','M','m','mm',
		'yy','y'
	);
	foreach($pattern as &$p)	{
		$p = '/'.$p.'/';
	}
	return preg_replace($pattern,$replace,$date);
}

function str_putcsv($array, $delimiter = ',', $enclosure = '"', $terminator = "\n") {
	# First convert associative array to numeric indexed array
	foreach ($array as $key => $value) $workArray[] = $value;

	$returnString = '';                 # Initialize return string
	$arraySize = count($workArray);     # Get size of array

	for ($i=0; $i<$arraySize; $i++) {
		# Nested array, process nest item
		if (is_array($workArray[$i])) {
			$returnString .= str_putcsv($workArray[$i], $delimiter, $enclosure, $terminator);
		} else {
			switch (gettype($workArray[$i])) {
				# Manually set some strings
				case "NULL":     $_spFormat = ''; break;
				case "boolean":  $_spFormat = ($workArray[$i] == true) ? 'true': 'false'; break;
				# Make sure sprintf has a good datatype to work with
				case "integer":  $_spFormat = '%i'; break;
				case "double":   $_spFormat = '%0.2f'; break;
				case "string":   $_spFormat = '%s'; $workArray[$i] = str_replace("$enclosure", "$enclosure$enclosure", $workArray[$i]); break;
				# Unknown or invalid items for a csv - note: the datatype of array is already handled above, assuming the data is nested
				case "object":
				case "resource":
				default:         $_spFormat = ''; break;
			}
							$returnString .= sprintf('%2$s'.$_spFormat.'%2$s', $workArray[$i], $enclosure);
				$returnString .= ($i < ($arraySize-1)) ? $delimiter : $terminator;
		}
	}
	# Done the workload, return the output information
	return $returnString;
}