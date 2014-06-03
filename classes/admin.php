<?php
/**
 * Wrangles our Admin settings.
 * Handles all of our Admin registration and output.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Admin
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Admin {

	/**
	 * Get things started
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function __construct() {
		$this->includes();
		$this->get_tabs();
		$this->register_default_form_settings();
		$this->register_default_field_settings();

		$this->license = new NF_License();

		// add admin menus
		add_action( 'admin_menu', array( $this, 'add_menu_page' ) );

		// add our settings via the options API
		add_action( 'admin_init', array( $this, 'add_plugin_settings' ) );

		// add a filter to the body class to specify which page we're on in the admin.
		add_filter( 'admin_body_class', array( $this, 'admin_body_filter' ) );
	}

	/**
	 * Include our admin class files
	 * 
	 * @access private
	 * @since 3.0
	 * @return void
	 */
	public function includes() {
		//Require EDD autoupdate file
		if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			// load our custom updater if it doesn't already exist
			require_once( NF_PLUGIN_DIR . 'classes/EDD_SL_Plugin_Updater.php' );
		}
		require_once( NF_PLUGIN_DIR . 'classes/extension-updater.php' );
		require_once( NF_PLUGIN_DIR . 'classes/license.php' );
	}

	/**
	 * Filter our admin body tag to add an appropriate Ninja Forms class name.
	 * 
	 * @access public
	 * @since 3.0
	 * @return string $classes
	 */
	public function admin_body_filter( $classes ) {
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

	/**
	 * Add our admin menu items
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function add_menu_page() {
		$page = add_menu_page( __( 'Ninja Forms', 'ninja-forms' ) , __( 'Ninja Forms', 'ninja-forms' ), apply_filters( 'nf_admin_menu_capabilities', 'manage_options' ), 'ninja-forms', array( $this, 'forms_admin' ), NF_PLUGIN_URL . "assets/images/nf-ico-small.png", "35.1337" );
		//add_action( 'admin_print_styles-' . $page, array( $this, 'admin_css' ) );

		$sub_page = add_submenu_page( 'ninja-forms', __( 'Ninja Forms', 'ninja-forms' ) , __( 'Forms', 'ninja-forms' ), apply_filters( 'nf_admin_menu_capabilities', 'manage_options' ), 'ninja-forms' );
		add_action( 'admin_print_styles-' . $sub_page, array( $this, 'admin_css' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_js' ) );		

		$settings = add_submenu_page( 'ninja-forms', __( 'Settings', 'ninja-forms' ) , __( 'Settings', 'ninja-forms' ), apply_filters( 'nf_admin_menu_settings_capabilities', 'manage_options' ), 'ninja-forms-settings', array( $this, 'output_settings_page' ) );
		//add_action( 'admin_print_styles-' . $sub_page, array( $this, 'admin_css' ) );
		//add_action( 'admin_enqueue_scripts', array( $this, 'admin_js' ) );

	}

	/**
	 * Enqueue our admin JS files
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function admin_js() {
		wp_enqueue_script( 'nf-admin', NF_PLUGIN_URL . 'assets/js/dev/admin.js', array( 'jquery', 'jquery-ui-datepicker', 'jquery-ui-sortable' ) );
		if ( isset ( $_GET['action'] ) && $_GET['action'] == 'edit' ) {
			wp_enqueue_script( 'nf-edit-form', NF_PLUGIN_URL . 'assets/js/dev/edit-form.js', array( 'jquery' ) );
			wp_localize_script( 'nf-edit-form', 'nf_rest_url', admin_url( 'admin.php?page=ninja-forms&nf_rest=rest_api' ) );
			wp_enqueue_script( 'nf-modal', NF_PLUGIN_URL . 'assets/js/min/jquery.modal.min.js', array( 'jquery' ) );
			if ( isset ( $_GET['form_id'] ) ) {
				wp_localize_script( 'nf-edit-form', 'nf_form_id', $_GET['form_id'] );
			}
		}
	}

	/**
	 * Enqueue our admin CSS
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function admin_css() {
		wp_enqueue_style( 'nf-admin', NF_PLUGIN_URL . 'assets/css/admin.css' );
	}

	/**
	 * Output our admin page
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function forms_admin() {

		if ( ! isset ( $_GET['action'] ) || $_GET['action'] != 'edit' ) {
			/** Show our all forms table. **/
			$this->output_all_forms_page();
		} else {
			/** Show our edit forms admin. **/
			$this->output_edit_form_page();
		}

		// echo "RENDER A FORM";
		// //Ninja_Forms()->form( 1 )->update_setting( 'name', 'Your First Name' );
		// Ninja_Forms()->form( 1 )->render();

		// // echo "<br><br><br>";
		// // echo "RENDER A FIELD BY KEY NAME";

		// // Ninja_Forms()->form( 1 )->field( 'firstname' )->render();

		// // echo "<br><br><br>";
		// // echo "GET A FIELD SETTING BY KEY NAME: ";
		// // echo "<strong>";

		// // print_r( Ninja_Forms()->form( 1 )->field( 'firstname' )->get_setting( 'label' ) );
		// // echo "</strong>";

		// // var_dump( Ninja_Forms()->field( 9 )->get_value() );

		// //var_dump( Ninja_Forms()->field( 9 )->type->add_to_sub );

		// echo "<pre>";
		// print_r( Ninja_Forms()->form( 1 )->field( 'lastname' )->get_value() );
		// echo "</pre>";
	}

	/**
	 * Output our all forms page
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function output_all_forms_page() {
		//Create an instance of our package class...
	    $nf_all_forms = new NF_All_Forms_List_Table();
	    //Fetch, prepare, sort, and filter our data...
	    $nf_all_forms->prepare_items();
	    ?>
	    <div class="wrap">
        
        <div id="icon-users" class="icon32"><br/></div>
        <h2><?php _e( 'Forms', 'ninja-forms' ); ?> <?php echo sprintf('<a href="?page=%s&action=%s" class="add-new-h2">',$_REQUEST['page'],'new' ); _e( 'Add New', 'ninja-forms' );?></a></h2>
        
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="forms-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $nf_all_forms->display() ?>
        </form>
        
    	</div>
    	<?php
	}

	/**
	 * Register our default form settings and sidebars.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function register_default_form_settings() {
		// Register our default form settings sidebars
		Ninja_Forms()->register->form_settings_menu( 'display', 'Display' );
		Ninja_Forms()->register->form_settings_menu( 'sub_limit', 'Limit Submissions' );

		// Register our default form settings
		$display = apply_filters( 'nf_display_form_settings', array(
			'logged_in' 	=> array(
				'id' 		=> 'logged_in',
				'type' 		=> 'checkbox',
				'name' 		=> __( 'Only show if the user is logged-in', 'ninja-forms' ),
				'desc' 		=> '',
				'help_text' => '',
				'std' 		=> 0,
			),
			'append_page' 	=> array(
				'id' 		=> 'append_page',
				'type' 		=> 'select',
				'name' 		=> __( 'Add This Form To This Page', 'ninja-forms' ),
				'desc' 		=> '',
				'help_text' =>'',
				'std' 		=> '',
				'options' 	=> array(
					array( 'name' => 'TEST1', 'value' => 'test1' ),
					array( 'name' => 'TEST2', 'value' => 'test2' ),
				),
			),
			'ajax' 			=> array(
				'id' 		=> 'ajax',
				'type' 		=> 'checkbox',
				'name' 		=> __( 'Submit this form without reloading the page?', 'ninja-forms' ),
				'desc' 		=> '',
				'help_text' => '',
				'std' 		=> 0,
			),
		) );

		Ninja_Forms()->register->form_settings( 'display', $display );

		$sub_limit = apply_filters( 'nf_sub_limit_form_settings', array(
			'sub_limit_number' 	=> array(
				'id'			=> 'sub_limit_number',
				'type'			=> 'number',
				'name' 			=> __( 'Limit Submissions', 'ninja-forms' ),
				'desc' 			=> '',
				'help_text'		=> '',
				'std' 			=> ''
			),
			'sub_limit_msg'		=> array(
				'id'			=> 'sub_limit_msg',
				'type'			=> 'textarea',
				'name'			=> __( 'Limit Reached Message', 'ninja-forms' ),
				'desc'			=> '',
				'help_text'		=> '',
				'std'			=> '',
			),
		));

		Ninja_Forms()->register->form_settings( 'sub_limit', $sub_limit );

		do_action( 'nf_register_form_settings' );

	}

	/**
	 * Register our default field settings and sidebars
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function register_default_field_settings() {
		// Register our default form settings sidebars
		Ninja_Forms()->register->field_settings_menu( 'general', 'General' );
		Ninja_Forms()->register->field_settings_menu( 'label', 'Label' );

		// Register our default form settings
		$general = apply_filters( 'nf_general_field_settings', array(
			'logged_in' 	=> array(
				'id' 		=> 'logged_in',
				'type' 		=> 'checkbox',
				'name' 		=> __( 'Required Field Label', 'ninja-forms' ),
				'desc' 		=> '',
				'help_text' => '',
				'std' 		=> 0,
			),
			'append_page' 	=> array(
				'id' 		=> 'append_page',
				'type' 		=> 'select',
				'name' 		=> __( 'Add This Form To This Page', 'ninja-forms' ),
				'desc' 		=> '',
				'help_text' =>'',
				'std' 		=> '',
				'options' 	=> array(
					array( 'name' => 'TEST1', 'value' => 'test1' ),
					array( 'name' => 'TEST2', 'value' => 'test2' ),
				),
			),
			'ajax' 			=> array(
				'id' 		=> 'ajax',
				'type' 		=> 'checkbox',
				'name' 		=> __( 'Submit this form without reloading the page?', 'ninja-forms' ),
				'desc' 		=> '',
				'help_text' => '',
				'std' 		=> 0,
			),
		) );

		Ninja_Forms()->register->field_settings( 'general', $general );

		$label = apply_filters( 'nf_label_field_settings', array(
			'sub_limit_number' 	=> array(
				'id'			=> 'sub_limit_number',
				'type'			=> 'number',
				'name' 			=> __( 'Limit Submissions', 'ninja-forms' ),
				'desc' 			=> '',
				'help_text'		=> '',
				'std' 			=> ''
			),
			'sub_limit_msg'		=> array(
				'id'			=> 'sub_limit_msg',
				'type'			=> 'textarea',
				'name'			=> __( 'Limit Reached Message', 'ninja-forms' ),
				'desc'			=> '',
				'help_text'		=> '',
				'std'			=> '',
			),
		));

		Ninja_Forms()->register->field_settings( 'label', $label );

		do_action( 'nf_register_field_settings' );
	}

	/**
	 * Output our edit form page
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function output_edit_form_page() {
		$form_id = ( isset ( $_GET['form_id'] ) ? $_GET['form_id'] : '' );
		$form_name = nf_get_form_setting( $form_id, 'name' );
		?>
		<div id="icon-ninja-custom-forms" class="icon32"><br></div>
		<h2><?php _e( 'Form Editor', 'ninja-forms' );?> - <?php if ( isset ( $form_name ) ) echo $form_name;?> - ID : <?php echo $form_id;?></h2>

		<div id="nav-menus-frame">
			<div id="menu-settings-column" class="metabox-holder">

				<div class="clear"></div>

				<div id="side-sortables" class="accordion-container">

					<ul class="outer-border">
						<?php
						foreach ( $this->get_field_menu() as $slug => $sidebar ) {
							?>
							<li class="control-section accordion-section open add-page top" id="add-page">
								<h3 class="accordion-section-title hndle" tabindex="0" title="Pages"><?php _e( $sidebar['label'], 'ninja-forms' ); ?></h3>
								<div class="accordion-section-content ">
									<div class="inside">
										<?php

										if ( isset ( $sidebar['callback'] ) ) {
											if ( ( is_array( $sidebar['callback'] ) && method_exists( $sidebar['callback'][0], $sidebar['callback'][1] ) ) || ( is_string( $sidebar['callback'] ) && function_exists( $sidebar['callback'] ) ) ) {
												$arguments = array( 'form_id' => $form_id );
												call_user_func_array( $sidebar['callback'], $arguments );
											} 
										} else {
											foreach ( $this->get_sidebar_fields( $slug ) as $field_type ) {
												$nicename = Ninja_Forms()->field_types->$field_type->nicename;
											?>
												<div class="button button-secondary ninja-forms-field-button"><?php _e( $nicename, 'ninja-forms' ); ?></div>
											<?php
											}

										}
										?>
									</div><!-- .inside -->
								</div><!-- .accordion-section-content -->
							</li><!-- .accordion-section -->
							<?php
						}
						?>
					</ul><!-- .outer-border -->
				</div><!-- .accordion-container -->
			</div><!-- /#menu-settings-column -->

			<div id="menu-management-liquid">
				<div id="menu-management">
					<div class="menu-edit ">
						<div id="nav-menu-header">
							<div class="major-publishing-actions">
								<div class="publishing-action">
									<a href="#nf-settings-modal" rel="modal:open"><input type="button" id="form_settings" class="open-settings-modal button button-secondary" value="<?php _e( 'Form Settings', 'ninja-forms' ); ?>"></a>
								</div><!-- END .publishing-action -->
							</div><!-- END .major-publishing-actions -->
						</div><!-- END .nav-menu-header -->
						<div id="post-body">
							<div id="post-body-content">
								<h3>Forms Structure</h3>
								<p>Drag each item into the order you prefer. Click edit to reveal additional options.</p>
								<div id="nf_field_list">
									<!-- Field ULs are added here via Backbone. -->
								</div>
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

		<div id="hidden_editor_div" class="hidden">
			<?php wp_editor( 'hidden_editor', 'hidden_editor', array( 'editor_class' => 'nf-setting') ); ?>
		</div>

		<!-- NF SETTINGS MODAL -->

		<div id="nf-settings-modal" style="display:none;">
			<a class="media-modal-close" href="#" title="Close">
		  		<span class="media-modal-icon"></span>
		  	</a>
	  		<div class="media-frame-menu">
				<div id="nf-settings-menu" class="media-menu">
					
				</div>
			</div>
			<div class="nf-settings">
				<div class="nf-settings-title">
					<h1 id="nf-settings-h1"><div id="nf_form_h1" style="display:none;"><?php _e( 'Form Settings', 'ninja-forms' ); ?></div><div id="nf_field_h1" style="display:none;"><?php _e( 'Field Settings', 'ninja-forms' ); ?></div></h1>
					<div class="updated" style="display:none"><?php _e( 'Saving...', 'ninja-forms' ); ?></div>
				</div>
				<div class="nf-settings-desc-desc"></div>
				<div class="nf-settings-content-wrap">
					<div class="nf-settings-content" id="nf-settings-content">
					</div>
				</div>
			</div>
		</div>

		<!-- /NF SETTINGS MODAL -->

		<!-- Begin Backbone.js Underscore templates -->

		<!-- Field List item template -->
		<script type="text/html" id="tmpl-nf-field-list">
			<ul class="ninja-row ninja-drop" data-cols="1" style="padding:2px;" id="nf_field_<%= field.get( 'id' ) %>">
				<li class="ninja-col-1-1" data-size="1-1" id="4x4">
					<div class="ninja-forms-admin-field label-above open-settings-modal">
						<%= _.template( jQuery( '#tmpl-nf-field-list-item-' + field.get( 'type' ) ).html(), { field: field } ) %>
					</div>
				</li>
			</ul>
		</script>

		<!-- Field list item disabled element template -->
		<?php
		// Loop through our registered field types and output their "field_list_element" function.
		foreach ( Ninja_Forms()->registered_field_types as $slug => $class_name ) {
			?>
			<script type="text/html" id="tmpl-nf-field-list-item-<?php echo $slug; ?>">
				<label><%= field.get( 'label' ) %></label>
				<?php
				Ninja_Forms()->field_types->$slug->field_list_element();
				?>
				<div class="nf-footer-left">
					<a href="#nf-settings-modal" rel="modal:open" class="open-settings-modal edit-field" data-field-id="<%= field.get( 'id' ) %>" data-field-title="<%= field.get( 'label' ) %> - ID: <%= field.get( 'id' ) %>">Edit</a> <a href="#" data-field-id="<%= field.get( 'id' ) %>" class="delete-field trash">Delete</a>
				</div>
				<div class="nf-footer-right">
					<%= field.get( 'type' ) %> - ID : <%= field.get( 'id' ) %>
				</div>	
			</script>
		<?php
		}
		?>

		<!-- Settings Menu template -->

		<script type="text/html" id="tmpl-nf-settings-menu">
			<%
			_.each( menus, function( menuItem ) {
				if ( menuItem.get( 'active' ) == 1 ) {
					var active_class = 'active';
				} else {
					var active_class = '';
				}
			%>
				<a href="#" class="media-menu-item nf-settings-menu <%= active_class %>" data-menu-item="<%= menuItem.get( 'id' ) %>" data-object-type="<%= menuItem.get( 'object_type' ) %>" data-object-id="<%= menuItem.get( 'object_id' ) %>" title=""><%= menuItem.get( 'nicename' ) %></a>
			<%
			});
			%>
			
		</script>

		<!-- Settings modal HR template -->

		<script type="text/html" id="tmpl-nf-settings-h1">
			<%= title %>
		</script>

		<!-- Settings form elements template -->

		<script type="text/html" id="tmpl-nf-settings">
			<table class="nf-table form-table">
			<% _.each(settings, function(setting){
				var setting_id = setting.get( 'id' );
				var value = setting.get( 'current_value' );

				// Check to see if this field should be visible
				if ( typeof setting.get( 'visible' ) == 'undefined' ) {
					var visible = true;
				} else {
					var visible = setting.get( 'visible' );
				}

				if ( !visible ) {
					visible = 'hidden';
				} else {
					visible = '';
				}

				// Loop through our 'data' settings and setup our 'data-attribute' tags.
				if ( typeof setting.get( 'data' ) !== 'undefined' ) {
					var data = setting.get( 'data' );
					var data_attributes = '';
					for ( prop in data ) {
						data_attributes += 'data-' + prop + '="' + data[prop] + '"';
					}
				}
				%>
				<tr class= "nf-<%= setting.get('type') %> <%= visible %>">
				<%
				switch( setting.get('type') ) {

					case 'checkbox':
						%>
						<th>
							<label for="<%= setting.id %>">
								<%= setting.get( 'name' ) %>
							</label>
						</th>
						<td>
							<input type="checkbox" id="<%= setting.id %>" class="<%= setting.get('class') %> nf-setting" value="1" <% if ( value == 1 ) { %>checked<%}%> <%= data_attributes %>>
							<span class="howto">
								<%= setting.get( 'desc' ) %>
							</span>
						</td>
						<%
						break;
					case 'select':
						%>
						<th>
							<label for="<%= setting.id %>">
								<%= setting.get( 'name' ) %>
							</label>
						</th>
						<td>
							<select id="<%= setting_id %>" class="<%= setting.get('class') %> nf-setting" data-meta-key="<%= setting.get( 'meta_key' )%>" data-object-id="<%= setting.get( 'object_id' ) %>" <%= data_attributes %>>
							<%

							_.each(setting.get('options'), function(option) {
								%>
								<option value="<%= option.value %>" <% if ( value == option.value ) { %> selected <% } %>><%= option.name %></option>
								<%
							});
							%>
							</select>
							<span class="howto">
								<%= setting.get( 'desc' ) %>
							</span>
							<div class="nf-help">
								
							</div>
						</td>
						<%
						break;
					case 'number':
						%>
						<th>
							<label for="<%= setting.id %>">
								<%= setting.get( 'name' ) %>
							</label>
						</th>
						<td>
							<input type="number" id="<%= setting_id %>" class="<%= setting.get('class') %> nf-setting" value="<%= value %>" min="<%= setting.get('min') %>" max="<%= setting.get('max') %>"  <%= data_attributes %>/>
							<span class="howto">
								<%= setting.get( 'desc' ) %>
							</span>
						</td>
						<%
						break;
					case 'radio':
						%>
						<th>
							<span>
								<%= setting.get( 'name' ) %>
							</span>
						</th>
						<td>
							<%
							var x = 0;
							_.each(setting.get('options'), function(option) {
								%>
								<label>
									<input type="radio" name="<%= setting.id %>" value="<%= option.value %>" <% if ( value == option.value ) { %> checked <% } %> id="<%= setting_id %>" class="<%= setting.get('class') %> nf-setting" <%= data_attributes %>/>
									<%= option.name %>
								</label>
								<%
								x++;
							});
							%>
							</select>
							<span class="howto">
								<%= setting.get( 'desc' ) %>
							</span>
							<div class="nf-help">
								
							</div>
						</td>
						<%
						break;
					case 'text':
						%>
						<th>
							<label for="<%= setting.id %>">
								<%= setting.get( 'name' ) %>
							</label>
						</th>
						<td>
							<input type="text" id="<%= setting_id %>" class="<%= setting.get('class') %> nf-setting" value="<%= value %>" title="TEST TEST TEST" <%= data_attributes %>/>
							<span class="howto">
								<%= setting.get( 'desc' ) %>
							</span>
							<div class="nf-help">
								
							</div>
						</td>
						<%
						break;					
					case 'textarea':
						%>
						<th colspan="2">
							<label for="<%= setting.id %>">
								<%= setting.get( 'name' ) %>
							</label>
							<textarea id="<%= setting_id %>" class="<%= setting.get('class') %> nf-setting" <%= data_attributes %>><%= value %></textarea>
							<span class="howto">
								<%= setting.get( 'desc' ) %>
							</span>
						</th>
						<%
						break;
					case 'repeater-text':

						%>
						<th>
							<label for="<%= setting.id %>">
								<%= setting.get( 'name' ) %> <a href="#" id="<%= setting_id %>" class="repeater-add">Add New</a> <br />
							</label>
						</th>
						<td>
							<span id="<%= setting_id %>_span">
								<%
								if ( typeof value === 'object' ) {
									_.each(value, function(val) {
										%>
										<span>
											<input type="text" id="" class="<%= setting.get('class') %> repeater-<%= setting_id %> repeater-text nf-setting" value="<%= val %>" data-group="<%= setting_id %>" /> - <a href="#" id="<%= setting_id %>" class="repeater-remove">X</a>
											<br />
										</span>
										<%
									});
								} else {
									%>
									<span>
										<input type="text" id="" class="<%= setting.get('class') %> repeater-<%= setting_id %> repeater-text nf-setting" value="" data-group="<%= setting_id %>" /> - <a href="#" id="<%= setting_id %>" class="">X</a>
										<br />
									</span>
									<%
								}
								%>
							</span>
						</td>
						<%
						break;
					case 'rte':
						%>
						<th class="nf-rte" colspan="2">
							<label for="<%= setting.id %>">
								<%= setting.get( 'name' ) %>
							</label>
							<div id="<%= setting_id %>_replace"></div>
							<span class="howto">
								<%= setting.get( 'desc' ) %>
							</span>
						</th>
						<%
						break;
				}
				%>

			</tr>
			<% }); %>
			</table>
		</script>

		<?php
	}

	/**
	 * Get our field settings menu links
	 * 
	 * @access public
	 * @since 3.0
	 * @return array $menu
	 */
	public function get_field_settings_menu( $field_id ) {
		$field_type = nf_get_field_type( $field_id );
		$menu = wp_parse_args( Ninja_Forms()->field_types->$field_type->settings_menu, Ninja_Forms()->registered_field_settings_menu );
		ksort( $menu );
		return $menu;
	}

	/**
	 * Get our field settings
	 * 
	 * @access public
	 * @since 3.0
	 * @return array $settings
	 */
	public function get_field_settings( $field_id, $menu = '' ) {
		$field_type = nf_get_field_type( $field_id );
		$settings = array_merge_recursive( Ninja_Forms()->registered_field_settings, Ninja_Forms()->field_types->$field_type->registered_settings );
		if ( $menu != '' ) {
			return $settings[ $menu ];	
		} else {
			return $settings;
		}
	}

	/**
	 * Get our field sidebars
	 * 
	 * @access public
	 * @since 3.0
	 * @return array $sidebars
	 */
	public function get_field_menu() {
		$sidebars = array(
			'favorite' => array(
				'label' => __( 'Favorite Fields', 'ninja-forms' ),
				'callback' => array( $this, 'favorite_fields_sidebar' ),
			),
			'general' => array(
				'label' => __( 'General Fields', 'ninja-forms' ),
			),
			'user_info' => array(
				'label' => __( 'User Information', 'ninja-forms' ),
			),
			'layout' => array(
				'label' => __( 'Layout Elements', 'ninja-forms' ),
			),
			'spam' => array(
				'label' => __( 'Spam Prevention', 'ninja-forms' ),
			),
			'calc' => array(
				'label' => __( 'Calculations', 'ninja-forms' ),
			),
		);

		return apply_filters( 'nf_field_menu', $sidebars );
	}

	/**
	 * Return all the field types registered to a specific sidebar
	 * 
	 * @access public
	 * @since 3.0
	 * @return array $fields
	 */
	public function get_sidebar_fields( $slug ) {
		$fields = array();
		foreach( Ninja_Forms()->registered_field_types as $field_slug => $field_type ) {
			if ( Ninja_Forms()->field_types->$field_slug->sidebar == $slug ) {
				$fields[] = $field_slug;
			}
		}
		return $fields;
	}

	public function favorite_fields_sidebar() {
		echo "TEST";
	}

	/**
	 * Get our plugin settings tabs
	 * 
	 * @access public
	 * @since 3.0
	 * @return array $tabs
	 */
	public function get_tabs() {
		$settings = $this->get_registered_settings();

		$tabs             		= array();
		$tabs['general']  		= __( 'General', 'ninja-forms' );
		$tabs['labels']      	= __( 'Labels', 'ninja-forms' );
		$tabs['types']			= __( 'Form Types', 'ninja-forms' );	

		if( ! empty( $settings['licenses'] ) ) {
			$tabs['licenses'] = __( 'Licenses', 'ninja-forms' );
		}

		return apply_filters( 'nf_settings_tabs', $tabs );
	}

	/**
	 * Get our default settings array
	 * These settings are filtered so that they can be added to by other plugins.
	 * 
	 * @access public
	 * @since 3.0
	 * @return array $settings
	 */
	public function get_registered_settings() {
		$settings = array(
			/** General Settings */
			'general' => apply_filters( 'nf_settings_general',
				array(
					'date_format' => array(
						'id' => 'date_format',
						'name' => __( 'Date Format', 'ninja-forms' ),
						'desc' => __( 'e.g. m/d/Y, d/m/Y - Tries to follow the <a href="http://www.php.net/manual/en/function.date.php" target="_blank">PHP date() function</a> specifications, but not every format is supported.', 'ninja-forms' ),
						'type' => 'text'
					),					
					'currency_symbol' => array(
						'id' => 'currency_symbol',
						'name' => __( 'Currency Symbol', 'ninja-forms' ),
						'desc' => __( 'e.g. $, &pound;, &euro;', 'ninja-forms' ),
						'type' => 'text',
						'size' => 'small'
					),
				)
			),
			/** Label Settings */
			'labels' => apply_filters( 'nf_settings_label',
				array(
					'req_div_label' => array(
						'id' => 'req_div_label',
						'type' => 'text',
						'name' => __( 'Required Field Label', 'ninja-forms' ),
						'desc' => '',
						'help_text' => '',
						'std' => __( 'Fields marked with a * are required.', 'ninja-forms' ),
					),
					'req_field_symbol' => array(
						'id' => 'req_field_symbol',
						'type' => 'text',
						'name' => __( 'Required field symbol', 'ninja-forms' ),
						'std' => '*',
					),
					'req_error_label' => array(
						'id' => 'req_error_label',
						'type' => 'text',
						'name' => __( 'Error message given if all required fields are not completed', 'ninja-forms' ),
						'std' => __( 'Please ensure all required fields are completed.', 'ninja-forms' ),
					),
					'req_field_error' => array(
						'id' => 'req_field_error',
						'type' => 'text',
						'name' => __( 'Required Field Error', 'ninja-forms' ),
						'desc' => '',
						'std' => __( 'This is a required field.', 'ninja-forms' ),
					),
					'spam_error' => array(
					 	'id' => 'spam_error',
						'type' => 'text',
						'name' => __( 'Anti-spam error message', 'ninja-forms' ),
						'desc' => '',
						'std' => __( 'Please answer the anti-spam question correctly.', 'ninja-forms' ),
					),
					'honeypot_error' => array(
					 	'id' => 'honeypot_error',
						'type' => 'text',
						'name' => __( 'Honeypot error message', 'ninja-forms' ),
						'desc' => '',
						'std' => __( 'If you are a human, please leave this field blank.', 'ninja-forms' ),
					),
					'timed_submit_error' => array(
					 	'id' => 'timed_submit_error',
						'type' => 'text',
						'name' => __( 'Timer error message', 'ninja-forms' ),
						'desc' => '',
						'std' => __( 'If you are a human, please slow down.', 'ninja-forms' ),
					),
					'javascript_error' => array(
						'id' => 'javascript_error',
						'type' => 'text',
						'name' => __( 'JavaScript disabled error message', 'ninja-forms' ),
						'desc' => '',
						'std' => __( 'You need JavaScript to submit this form. Please enable it and try again.', 'ninja-forms' ),
					),
					'invalid_email' => array(
					 	'id' => 'invalid_email',
						'type' => 'text',
						'name' => __( 'Please enter a valid email address', 'ninja-forms' ),
						'desc' => '',
						'std' => __( 'Please enter a valid email address.', 'ninja-forms' ),
					),
					'process_label' => array(
						'id' => 'process_label',
						'type' => 'text',
						'name' => __( 'Processing Submission Label', 'ninja-forms' ),
						'desc' => __( 'This message is shown inside the submit button whenever a user clicks "submit" to let them know it is processing.', 'ninja-forms' ),
						'std' => __( 'Processing', 'ninja-forms' ),
					),
				)
			),
			/** Licenses */
			'licenses' => apply_filters( 'nf_settings_licenses', array() ),
		);

		return apply_filters( 'nf_plugin_settings', $settings );
	}

	/**
	 * Update our plugin settings
	 * 
	 * @access public
	 * @since 3.0
	 * @return array $settings
	 */
	public function update_plugin_settings( $key, $value ) {
		Ninja_Forms()->plugin_settings[$key] = $value;
		update_option( 'nf_settings', Ninja_Forms()->plugin_settings );
	}

	/**
	 * Output our settings page
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function output_settings_page() {
		$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
		?>
		<div class="wrap">
			<div id="icon-themes" class="icon32"></div>
			<h2 class="nav-tab-wrapper">
				<?php
				foreach ( $this->get_tabs() as $slug => $nicename ) {
					?>
					<a href="<?php echo add_query_arg( 'tab', $slug, remove_query_arg('settings-updated' ) ); ?>" class="nav-tab <?php echo $active_tab == $slug ? 'nav-tab-active' : ''; ?>"><?php echo $nicename; ?></a>
					<?php
				}
				?>
			</h2>
			<?php settings_errors(); ?>
			 <form method="post" action="options.php">
	            <?php
	            settings_fields( 'nf_settings' );
	            do_settings_sections( 'nf_settings_' . $active_tab );
	            submit_button(__( 'Save', 'ninja-forms' ) );
	            ?>
	        </form>
		</div>

		<?php
	}

	/**
	 * Add our plugin settings via the Options API
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function add_plugin_settings() {
		if ( false == get_option( 'nf_settings' ) ) {
			add_option( 'nf_settings' );
		}

		foreach( $this->get_registered_settings() as $tab => $settings ) {

			add_settings_section(
				'nf_settings_' . $tab,
				__return_null(),
				'__return_false',
				'nf_settings_' . $tab
			);

			foreach ( $settings as $option ) {

				$name = isset( $option['name'] ) ? $option['name'] : '';

				add_settings_field(
					'nf_settings[' . $option['id'] . ']',
					$name,
					method_exists( $this, $option['type'] . '_callback' ) ? array( $this, $option['type'] . '_callback' ) : array( $this, 'missing_callback' ),
					'nf_settings_' . $tab,
					'nf_settings_' . $tab,
					array(
						'id'      => isset( $option['id'] ) ? $option['id'] : null,
						'desc'    => ! empty( $option['desc'] ) ? $option['desc'] : '',
						'name'    => isset( $option['name'] ) ? $option['name'] : null,
						'section' => $tab,
						'size'    => isset( $option['size'] ) ? $option['size'] : null,
						'options' => isset( $option['options'] ) ? $option['options'] : '',
						'std'     => isset( $option['std'] ) ? $option['std'] : ''
					)
				);
			}

		}

		// Creates our settings in the options table
		register_setting( 'nf_settings', 'nf_settings', array( $this, 'nf_settings_sanitize' ) );
	}

	/**
	 * Sanitize and organize our saved settings so that they are all stored in the same option
	 * 
	 * @access public
	 * @since 3.0
	 * @return array $output
	 */
	public function nf_settings_sanitize( $input = array() ) {

		if ( empty( $_POST['_wp_http_referer'] ) ) {
			return $input;
		}

		parse_str( $_POST['_wp_http_referer'], $referrer );

		$settings = $this->get_registered_settings();
		$tab      = isset( $referrer['tab'] ) ? $referrer['tab'] : 'general';

		$input = $input ? $input : array();
		$input = apply_filters( 'nf_settings_' . $tab . '_sanitize', $input );

		// Loop through each setting being saved and pass it through a sanitization filter
		foreach ( $input as $key => $value ) {

			// Get the setting type (checkbox, select, etc)
			$type = isset( $settings[$tab][$key]['type'] ) ? $settings[$tab][$key]['type'] : false;

			if ( $type ) {
				// Field type specific filter
				$input[$key] = apply_filters( 'nf_settings_sanitize_' . $type, $value, $key );

			}

			// General filter
			$input[$key] = apply_filters( 'nf_settings_sanitize', $input[$key], $key );
		}
		
		// Loop through the whitelist and unset any that are empty for the tab being saved
		if ( ! empty( $settings[$tab] ) ) {
			foreach ( $settings[$tab] as $key => $value ) {
				if ( empty( $input[$key] ) ) {
					//unset( Ninja_Forms()->plugin_settings[$key] );
				}
			}
		}

		// Merge our new settings with the existing
		$output = array_merge( Ninja_Forms()->plugin_settings, $input );

		add_settings_error( 'nf-notices', '', __( 'Settings updated.', 'nf-settings' ), 'updated' );
		return $output;
	}

	/** Callback functions for our settings pages */

	/**
	 * Callback function for our textboxes
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function text_callback( $args ) {
		if ( isset( Ninja_Forms()->plugin_settings[ $args['id'] ] ) )
			$value = Ninja_Forms()->plugin_settings[ $args['id'] ];
		else
			$value = isset( $args['std'] ) ? $args['std'] : '';

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="text" class="' . $size . '-text" id="nf_settings[' . $args['id'] . ']" name="nf_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
		$html .= '<label for="nf_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}		

	/**
	 * Callback function for our licenses
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function license_callback( $args ) {
		if ( isset ( Ninja_Forms()->plugin_settings[ $args['id'] . '_status' ] ) && Ninja_Forms()->plugin_settings[ $args['id'] . '_status' ] == 'valid' ) {
			$status = 'valid';
			$png = 'yes.png';
		} else {
			$status = 'invalid';
			$png = 'no.png';
		}
		$status = $this->license->get_license_status( $args['id'] . '_status' );

		if ( isset( Ninja_Forms()->plugin_settings[ $args['id'] ] ) )
			$value = Ninja_Forms()->plugin_settings[ $args['id'] ];
		else
			$value = isset( $args['std'] ) ? $args['std'] : '';

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<img src="' . NF_PLUGIN_URL . 'assets/images/' . $png . '"> <input type="text" class="' . $size . '-text" id="nf_settings[' . $args['id'] . ']" name="nf_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
		if ( $status == 'valid' ) {
			$html .= '<input type="submit" class="button-secondary" name="' . $args['id'] . '_deactivate" value="' . __( 'Deactivate License', 'ninja-forms' ) .'">';	
		} else {
			$html .= '<label for="nf_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';			
		}

		echo $html;
	}	

	/**
	 * Callback function for our checkboxes
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function checkbox_callback( $args ) {
		$checked = isset(Ninja_Forms()->plugin_settings[$args['id']]) ? checked(1, Ninja_Forms()->plugin_settings[$args['id']], false) : '';
		$html = '<input type="checkbox" id="nf_settings[' . $args['id'] . ']" name="nf_settings[' . $args['id'] . ']" value="1" ' . $checked . '/>';
		$html .= '<label for="nf_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}	

	/**
	 * Callback function for our multi-checkboxes
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function multicheck_callback( $args ) {
		if ( ! empty( $args['options'] ) ) {
			foreach( $args['options'] as $key => $option ):
				if( isset( Ninja_Forms()->plugin_settings[$args['id']][$key] ) ) { $enabled = $option; } else { $enabled = NULL; }
				echo '<input name="nf_settings[' . $args['id'] . '][' . $key . ']" id="nf_settings[' . $args['id'] . '][' . $key . ']" type="checkbox" value="' . $option . '" ' . checked($option, $enabled, false) . '/>&nbsp;';
				echo '<label for="nf_settings[' . $args['id'] . '][' . $key . ']">' . $option . '</label><br/>';
			endforeach;
			echo '<p class="description">' . $args['desc'] . '</p>';
		}
	}	

	/**
	 * Callback function for our hr tag
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function header_callback( $args ) {
		echo '<hr/>';
	}	

	/**
	 * Callback function for our radio buttons
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function radio_callback( $args ) {
		foreach ( $args['options'] as $key => $option ) :
			$checked = false;

			if ( isset( Ninja_Forms()->plugin_settings[ $args['id'] ] ) && Ninja_Forms()->plugin_settings[ $args['id'] ] == $key )
				$checked = true;
			elseif( isset( $args['std'] ) && $args['std'] == $key && ! isset( Ninja_Forms()->plugin_settings[ $args['id'] ] ) )
				$checked = true;

			echo '<input name="nf_settings[' . $args['id'] . ']"" id="nf_settings[' . $args['id'] . '][' . $key . ']" type="radio" value="' . $key . '" ' . checked(true, $checked, false) . '/>&nbsp;';
			echo '<label for="nf_settings[' . $args['id'] . '][' . $key . ']">' . $option . '</label><br/>';
		endforeach;

		echo '<p class="description">' . $args['desc'] . '</p>';
	}	

	/**
	 * Callback function for our selects
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function select_callback( $args ) {
		if ( isset( Ninja_Forms()->plugin_settings[ $args['id'] ] ) )
			$value = Ninja_Forms()->plugin_settings[ $args['id'] ];
		else
			$value = isset( $args['std'] ) ? $args['std'] : '';

		$html = '<select id="nf_settings[' . $args['id'] . ']" name="nf_settings[' . $args['id'] . ']"/>';

		foreach ( $args['options'] as $option => $name ) :
			$selected = selected( $option, $value, false );
			$html .= '<option value="' . $option . '" ' . $selected . '>' . $name . '</option>';
		endforeach;

		$html .= '</select>';
		$html .= '<label for="nf_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}	

	/**
	 * Callback function for our number field
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function number_callback( $args ) {
		if ( isset( Ninja_Forms()->plugin_settings[ $args['id'] ] ) )
			$value = Ninja_Forms()->plugin_settings[ $args['id'] ];
		else
			$value = isset( $args['std'] ) ? $args['std'] : '';

		$max  = isset( $args['max'] ) ? $args['max'] : 999999;
		$min  = isset( $args['min'] ) ? $args['min'] : 0;
		$step = isset( $args['step'] ) ? $args['step'] : 1;

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="number" step="' . esc_attr( $step ) . '" max="' . esc_attr( $max ) . '" min="' . esc_attr( $min ) . '" class="' . $size . '-text" id="nf_settings[' . $args['id'] . ']" name="nf_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
		$html .= '<label for="nf_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}	

	/**
	 * Callback function for our textareas
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function textarea_callback( $args ) {
		if ( isset( Ninja_Forms()->plugin_settings[ $args['id'] ] ) )
			$value = Ninja_Forms()->plugin_settings[ $args['id'] ];
		else
			$value = isset( $args['std'] ) ? $args['std'] : '';

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<textarea class="large-text" cols="50" rows="5" id="nf_settings[' . $args['id'] . ']" name="nf_settings[' . $args['id'] . ']">' . esc_textarea( stripslashes( $value ) ) . '</textarea>';
		$html .= '<label for="nf_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Callback function for our passwords
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function password_callback( $args ) {
		if ( isset( Ninja_Forms()->plugin_settings[ $args['id'] ] ) )
			$value = Ninja_Forms()->plugin_settings[ $args['id'] ];
		else
			$value = isset( $args['std'] ) ? $args['std'] : '';

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="password" class="' . $size . '-text" id="nf_settings[' . $args['id'] . ']" name="nf_settings[' . $args['id'] . ']" value="' . esc_attr( $value ) . '"/>';
		$html .= '<label for="nf_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Missing Callback
	 *
	 * If a function is missing for settings callbacks alert the user.
	 *
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function missing_callback($args) {
		printf( __( 'The callback function used for the <strong>%s</strong> setting is missing.', 'ninja-forms' ), $args['id'] );
	}

	/**
	 * Callback function for our color select
	 *
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function color_select_callback($args) {
		if ( isset( Ninja_Forms()->plugin_settings[ $args['id'] ] ) )
			$value = Ninja_Forms()->plugin_settings[ $args['id'] ];
		else
			$value = isset( $args['std'] ) ? $args['std'] : '';

		$html = '<select id="nf_settings[' . $args['id'] . ']" name="nf_settings[' . $args['id'] . ']"/>';

		foreach ( $args['options'] as $option => $color ) :
			$selected = selected( $option, $value, false );
			$html .= '<option value="' . $option . '" ' . $selected . '>' . $color['label'] . '</option>';
		endforeach;

		$html .= '</select>';
		$html .= '<label for="nf_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Callback function for our rich text editor
	 *
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function rte_callback($args) {
		global $wp_version;
		if ( isset( Ninja_Forms()->plugin_settings[ $args['id'] ] ) )
			$value = Ninja_Forms()->plugin_settings[ $args['id'] ];
		else
			$value = isset( $args['std'] ) ? $args['std'] : '';

		if ( $wp_version >= 3.3 && function_exists( 'wp_editor' ) ) {
			ob_start();
			wp_editor( stripslashes( $value ), 'nf_settings_' . $args['id'], array( 'textarea_name' => 'nf_settings[' . $args['id'] . ']' ) );
			$html = ob_get_clean();
		} else {
			$html = '<textarea class="large-text" rows="10" id="nf_settings[' . $args['id'] . ']" name="nf_settings[' . $args['id'] . ']">' . esc_textarea( stripslashes( $value ) ) . '</textarea>';
		}

		$html .= '<br/><label for="nf_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Callback function for our file upload
	 *
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function upload_callback($args) {
		if ( isset( Ninja_Forms()->plugin_settings[ $args['id'] ] ) )
			$value = Ninja_Forms()->plugin_settings[$args['id']];
		else
			$value = isset($args['std']) ? $args['std'] : '';

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="text" class="' . $size . '-text nf_upload_field" id="nf_settings[' . $args['id'] . ']" name="nf_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
		$html .= '<span>&nbsp;<input type="button" class="nf_settings_upload_button button-secondary" value="' . __( 'Upload File', 'ninja-forms' ) . '"/></span>';
		$html .= '<label for="nf_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Callback function for our color picker
	 *
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function color_callback($args) {
		if ( isset( Ninja_Forms()->plugin_settings[ $args['id'] ] ) )
			$value = Ninja_Forms()->plugin_settings[ $args['id'] ];
		else
			$value = isset( $args['std'] ) ? $args['std'] : '';

		$default = isset( $args['std'] ) ? $args['std'] : '';

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="text" class="nf-color-picker" id="nf_settings[' . $args['id'] . ']" name="nf_settings[' . $args['id'] . ']" value="' . esc_attr( $value ) . '" data-default-color="' . esc_attr( $default ) . '" />';
		$html .= '<label for="nf_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Hook Callback
	 *
	 * Adds a do_action() hook in place of the field
	 *
	 * @access public
	 * @since 3.0
	 * @param array $args Arguments passed by the setting
	 * @return void
	 */
	public function hook_callback( $args ) {
		do_action( 'nf_' . $args['id'] );
	}

	/**
	 * Filter our license saving so that we can check its status
	 * 
	 * @access public
	 * @since 3.0
	 * @param array $args Arguments passed by the setting
	 * @return $value
	 */
	public function save_license_filter( $value, $key ) {

		return $value;
	}

}