<?php

function ninja_forms_add_menu(){
	$plugins_url = plugins_url();

	if ( isset ( $_REQUEST['page'] ) and $_REQUEST['page'] = 'ninja-forms-edit' and isset ( $_REQUEST['form_id'] ) ) {
		$edit_form_parent = 'ninja-forms';
	} else {
		$edit_form_parent = null;
	}

	$capabilities = 'manage_options';
	$capabilities = apply_filters( 'ninja_forms_admin_menu_capabilities', $capabilities );

	$page = add_menu_page("Ninja Forms" , __( 'Forms', 'ninja-forms' ), $capabilities, "ninja-forms", null, NINJA_FORMS_URL."/images/ninja-head-ico-small.png" );
		
	$all_forms = add_submenu_page("ninja-forms", __( 'Forms', 'ninja-forms' ), __( 'All Forms', 'ninja-forms' ), $capabilities, "ninja-forms", "ninja_forms_admin_all_forms");
	$edit_form = add_submenu_page( $edit_form_parent, __( 'Edit Form', 'ninja-forms' ), __( 'Edit Form', 'ninja-forms' ), $capabilities, "ninja-forms-edit", "ninja_forms_admin_edit_form");
	/*
	$new_form = add_submenu_page("ninja-forms", __( 'Add New', 'ninja-forms' ), __( 'Add New', 'ninja-forms' ), $capabilities, "ninja-forms&tab=form_settings&form_id=new", "ninja_forms_admin");
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
	global $wpdb, $ninja_forms_form_settings_tabs, $ninja_forms_form_settings;

	do_action( 'ninja_forms_register_form_settings' );

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
	<h2>Form Editor - Your Form Title - ID : 16</h2>

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
		
		<div class="media-frame-title">
			<h1></h1>
		</div>

		<div class="media-frame-router">
			
			<div class="media-router">
				<div class="media-frame-desc">
					
				</div>
				<div class="media-frame-save">

				</div>
				<!--<a href="#" class="media-menu-item">Tab #1</a>
				<a href="#" class="media-menu-item active">Tab #2</a>-->
			</div>
			
		</div>

		<div class="media-frame-content" id="my-content-id" style="overflow:scroll;">

			<p>Place your settings here.</p>


		</div>

	</div>

  </div>
  <?php
  /*
	foreach( $ninja_forms_form_settings as $tab=> $settings ){
		foreach( $settings as $id => $setting ) {
			if ( $setting['type'] == 'rte' ) {
	  		?>
		  <div id="<?php echo $id; ?>_div" class='hidden'>
		  	<?php wp_editor( 'test', $id ); ?>
		  </div>
	  <?php
			}
		}
	}
	*/

  ?>

	<script type="text/html" id="tmpl-form-settings">
		<br />
		<% _.each(settings, function(setting){
			var setting_id = setting.get( 'id' );
			var value = setting.get( 'current_value' );
			%>
			<div>
			<%
			switch( setting.get('type') ) {
				case 'checkbox':
					%>
					<label>
						<input type="checkbox" id="<%= setting.id %>" class="<%= setting.get('class') %>" value="1" <% if ( value == 1 ) { %>checked<%}%>>
						<%= setting.get('label') %>
					</label>
					<%
					break;
				case 'select':
					%>
					<label>
						<%= setting.get('label') %>
						<select id="<%= setting_id %>" class="<%= setting.get('class') %>">
						<%
						_.each(setting.get('options'), function(option) {
							%>
							<option value="<%= option.value %>" <% if ( value == option.value ) { %> selected <% } %>><%= option.name %></option>
							<%
						});
						%>
						</select>
					</label>
					<%
					break;
				case 'textarea':
					%>
					<label>
						<%= setting.get('label') %>
						<textarea id="<%= setting_id %>" class="<%= setting.get('class') %>"><%= value %></textarea>
					</label>
					<%
					break;
				case 'text':
					%>
					<label>
						<%= setting.get('label') %>
						<input type="text" id="<%= setting_id %>" class="<%= setting.get('class') %>" value="<%= value %>" />
					</label>
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
					<%= setting.get('label') %>
					<div id="<%= setting_id %>_replace"></div>
					<%
					break;
			}
			%>
			<span class="howto">
				<%= setting.get('desc') %>
			</span>
			</div>
		<% }); %>
	</script>
	<div id="hidden_editor_div" class="hidden">
		<?php wp_editor( 'test', 'hidden_editor' ); ?>
	</div>
<?php

}

function ninja_forms_admin_all_forms() {
	$all_forms = ninja_forms_get_all_forms();
	$form_count = count($all_forms);

	if( isset( $_REQUEST['limit'] ) ){
		$saved_limit = absint( $_REQUEST['limit'] );
		$limit = absint( $_REQUEST['limit'] );
	}else{
		$saved_limit = 20;
		$limit = 20;
	}

	if( $form_count < $limit ){
		$limit = $form_count;
	}

	if( isset( $_REQUEST['paged']) AND !empty( $_REQUEST['paged'] ) ){
		$current_page = absint( $_REQUEST['paged'] );
	}else{
		$current_page = 1;
	}

	if( $form_count > $limit ){
		$page_count = ceil( $form_count / $limit );
	}else{
		$page_count = 1;
	}

	if( $current_page > 1 ){
		$start = ( ( $current_page - 1 ) * $limit );
		if( $form_count < $limit ){
			$end = $form_count;
		}else{
			$end = $current_page * $limit;
			$end = $end - 1;
		}

		if( $end > $form_count ){
			$end = $form_count;
		}
	}else{
		$start = 0;
		$end = $limit;
	}

	?>
	<ul class="subsubsub">
		<li class="all"><a href="" class="current"><?php _e( 'All', 'ninja-forms' ); ?> <span class="count">(<?php echo $form_count;?>)</span></a>
	</ul>
	<div id="" class="tablenav top">
		<div class="alignleft actions">
			<select id="" class="" name="bulk_action">
				<option value=""><?php _e( 'Bulk Actions', 'ninja-forms' );?></option>
				<option value="delete"><?php _e( 'Delete', 'ninja-forms' );?></option>
				<!-- <option value="export"><?php _e( 'Export Forms', 'ninja-forms' );?></option> -->
			</select>
			<input type="submit" name="submit" value="<?php _e( 'Apply', 'ninja-forms' ); ?>" class="button-secondary">
		</div>
		<div class="alignleft actions">
			<select id="" name="limit">
				<option value="20" <?php selected($saved_limit, 20);?>>20</option>
				<option value="50" <?php selected($saved_limit, 50);?>>50</option>
				<option value="100" <?php selected($saved_limit, 100);?>>100</option>
			</select>
			<?php _e( 'Forms Per Page', 'ninja-forms' ); ?>
			<input type="submit" name="submit" value="<?php _e( 'Go', 'ninja-forms' ); ?>" class="button-secondary">
		</div>
		<div id="" class="alignright navtable-pages">
			<?php
			if($form_count != 0 AND $current_page <= $page_count){
			?>
			<span class="displaying-num"><?php if($start == 0){ echo 1; }else{ echo $start; }?> - <?php echo $end;?> <?php _e( 'of', 'ninja-forms' ); ?> <?php echo $form_count;?> <?php if($form_count == 1){ _e( 'Form', 'ninja-forms' ); }else{ _e( 'Forms', 'ninja-forms' ); }?></span>
			<?php
			}
				if($page_count > 1){

					$first_page = remove_query_arg('paged');
					$last_page = add_query_arg(array('paged' => $page_count));

					if($current_page > 1){
						$prev_page = $current_page - 1;
						$prev_page = add_query_arg(array('paged' => $prev_page));
					}else{
						$prev_page = $first_page;
					}
					if($current_page != $page_count){
						$next_page = $current_page + 1;
						$next_page = add_query_arg(array('paged' => $next_page));
					}else{
						$next_page = $last_page;
					}

			?>
			<span class="pagination-links">
				<a class="first-page disabled" title="<?php _e( 'Go to the first page', 'ninja-forms' ); ?>" href="<?php echo $first_page;?>">«</a>
				<a class="prev-page disabled" title="<?php _e( 'Go to the previous page', 'ninja-forms' ); ?>" href="<?php echo $prev_page;?>">‹</a>
				<span class="paging-input"><input class="current-page" title="Current page" type="text" name="paged" value="<?php echo $current_page;?>" size="2"> of <span class="total-pages"><?php echo $page_count;?></span></span>
				<a class="next-page" title="<?php _e( 'Go to the next page', 'ninja-forms' ); ?>" href="<?php echo $next_page;?>">›</a>
				<a class="last-page" title="<?php _e( 'Go to the last page', 'ninja-forms' ); ?>" href="<?php echo $last_page;?>">»</a>
			</span>
			<?php
				}
			?>
		</div>
	</div>
	<table class="wp-list-table widefat fixed posts">
		<thead>
			<tr>
				<th class="check-column"><input type="checkbox" id="" class="ninja-forms-select-all" title="ninja-forms-bulk-action"></th>
				<th><?php _e( 'Form Title', 'ninja-forms' );?></th>
				<th><?php _e( 'Shortcode', 'ninja-forms' );?></th>
				<th><?php _e( 'Template Function', 'ninja-forms' );?></th>
				<th><?php _e( 'Date Updated', 'ninja-forms' );?></th>
			</tr>
		</thead>
		<tbody>
	<?php
	if(is_array($all_forms) AND !empty($all_forms) AND $current_page <= $page_count){
		for ($i = $start; $i < $end; $i++) {
			$form_id = $all_forms[$i]['id'];
			$data = $all_forms[$i]['data'];
			$date_updated = $all_forms[$i]['date_updated'];
			$date_updated = strtotime( $date_updated );
			$date_updated = date_i18n( __( 'F d, Y', 'ninja-forms' ), $date_updated );
			$edit_link = esc_url( add_query_arg( array( 'form_id' => $form_id ), 'http://localhost:8888/wp-dev/wp-admin/admin.php?page=ninja-forms-edit' ) );
			$subs_link = admin_url( 'admin.php?page=ninja-forms-subs&form_id='.$form_id );
			$export_link = esc_url( add_query_arg( array( 'export_form' => 1, 'form_id' => $form_id ) ) );
			$duplicate_link = esc_url( add_query_arg( array( 'duplicate_form' => 1, 'form_id' => $form_id ) ) );
			?>
			<tr id="ninja_forms_form_<?php echo $form_id;?>_tr">
				<th scope="row" class="check-column">
					<input type="checkbox" id="" name="form_ids[]" value="<?php echo $form_id;?>" class="ninja-forms-bulk-action">
				</th>
				<td class="post-title page-title column-title">
					<strong>
						<a href="<?php echo $edit_link;?>"><?php echo $data['form_title'];?></a>
					</strong>
					<div class="row-actions">
						<span class="edit"><a href="<?php echo $edit_link;?>"><?php _e( 'Edit', 'ninja-forms' ); ?></a> | </span>
						<span class="trash"><a class="ninja-forms-delete-form" title="<?php _e( 'Delete this form', 'ninja-forms' ); ?>" href="#" id="ninja_forms_delete_form_<?php echo $form_id;?>"><?php _e( 'Delete', 'ninja-forms' ); ?></a> | </span>
						<span class="export"><a href="<?php echo $export_link;?>" title="<?php _e( 'Export Form', 'ninja-forms' ); ?>"><?php _e( 'Export', 'ninja-forms' ); ?></a> | </span>
						<span class="duplicate"><a href="<?php echo $duplicate_link;?>" title="<?php _e( 'Duplicate Form', 'ninja-forms' ); ?>"><?php _e( 'Duplicate', 'ninja-forms' ); ?></a> | </span>
						<span class="bleep"><?php echo ninja_forms_preview_link( $form_id ); ?> | </span>
						<span class="subs"><a href="<?php echo $subs_link;?>" class="" title="<?php _e( 'View Submissions', 'ninja-forms' ); ?>"><?php _e( 'View Submissions', 'ninja-forms' ); ?></a></span>
					</div>
				</td>
				<td>
					[ninja_forms_display_form id=<?php echo $form_id;?>]
				</td>
				<td>
					<pre>if( function_exists( 'ninja_forms_display_form' ) ){ ninja_forms_display_form( <?php echo $form_id;?> ); }</pre>
				</td>
				<td>
					<?php echo $date_updated;?>
				</td>
			</tr>

			<?php
		}
	}else{


	}	//End $all_forms if statement
	?>
		</tbody>
		<tfoot>
			<tr>
				<th class="check-column"><input type="checkbox" id="" class="ninja-forms-select-all" title="ninja-forms-bulk-action"></th>
				<th><?php _e( 'Form Title', 'ninja-forms' );?></th>
				<th><?php _e( 'Shortcode', 'ninja-forms' );?></th>
				<th><?php _e( 'Template Function', 'ninja-forms' );?></th>
				<th><?php _e( 'Date Updated', 'ninja-forms' );?></th>
			</tr>
		</tfoot>
	</table>
	<?php
}

if(is_admin()){
	//require_once(ABSPATH . 'wp-admin/includes/post.php');
}

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