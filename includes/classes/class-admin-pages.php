<?php
/**
 * Output Admin Settings Pages
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Admin Pages
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * This class handles displaying all settings pages.
 *
 * These settings include form, field, notification, and plugin settings.
 *
 * @since 3.0
 */
class NF_Admin_Settings_Pages {

	private $pages;

	/**
	 * Get everything started
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'default_admin_pages' ) );
	}

	/**
	 * Register an admin menu page
	 * 
	 * @access public
	 * @param array $args
	 * @since 3.0
	 * @return void
	 */

	public function register_admin_page( $args ) {
		$defaults = array(
			'parent_slug' 	=> 	'ninja-forms',
			'page_title' 	=>	'Forms',
			'menu_title'	=> 	'',
			'capabilities' 	=> 	'manage_options',
			'menu_slug'		=>	'',
			'function' 		=>	array( $this, 'render_page' ),
			'scope'			=> 	'',
			'object_id'		=> 	0,
		);

		// Parse incomming $args into an array and merge it with $defaults
		$args = wp_parse_args( $args, $defaults );

		if ( $args['menu_slug'] == '' ) {
			$args['menu_slug'] = sanitize_title( $args['menu_title'] );
		}

		$this->pages[ $args['menu_slug'] ] = $args;

		$page = add_submenu_page( $args['parent_slug'], __( $args['page_title'], 'ninja-forms' ), __( $args['menu_title'], 'ninja-forms' ), $args['capabilities'], $args['menu_slug'], array( $this, 'render_page') );
		
	}

	/**
	 * Render a settings page
	 * 
	 * @access public
	 * @param string $scope
	 * @since 3.0
	 * @return void
	 */

	public function render_page() {
		if ( isset ( $_REQUEST['page'] ) ) {
			$slug = $_REQUEST['page'];
		} else {
			return false;
		}

		$function = $this->pages[$slug]['function'];
		$scope = $this->pages[$slug]['scope'];
		$object_id = $this->pages[$slug]['object_id'];
		if ( is_string( $function ) ) {
			$arguments['scope'] = $scope;
			call_user_func_array( $function, $arguments );
		} else {
			$groups = Ninja_Forms()->admin_settings->get_settings_groups( $scope );
			$this->get_admin_template( $scope, $groups, $object_id );
			$this->get_backbone_template( $scope, $groups, $object_id );
		}
	}

	/**
	 * Render the admin page template
	 * 
	 * @access private
	 * @param array $groups
	 * @since 3.0
	 * @return void
	 */

	private function get_admin_template( $scope, $groups, $object_id ) {

		$high_priority_tabs = array();
		$core_priority_tabs = array();
		$default_priority_tabs = array();
		$low_priority_tabs = array();

		foreach ( $groups as $slug => $data ) {
			$priority = $data['priority'];
			if ( $priority == 'high' ) {
				$high_priority_tabs[$slug] = $data;
			} else if ( $priority == 'core' ) {
				$core_priority_tabs[$slug] = $data;
			} else if ( $priority == 'default' ) {
				$default_priority_tabs[$slug] = $data;
			} else if ( $priority == 'low' ) {
				$low_priority_tabs[$slug] = $data;
			}
		}
		?>
		<div id="" style="">
		  	<div class="" id="">

				<div class="media-frame-menu">
					<div class="media-menu">

						<?php
						if ( is_array( $high_priority_tabs ) and !empty( $high_priority_tabs ) ) {
							?>
							<div class="separator"></div>
							<?php
						}
						$active = false;
						foreach( $high_priority_tabs as $group => $settings ){
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
							if ( isset ( $settings['custom'] ) ) {
								$custom = $settings['custom'];
							} else {
								$custom = false;
							}

							if ( isset ( $settings['display_link'] ) and $settings['display_link'] ) {
						?>
						<a href="#<?php echo $group;?>" class="media-menu-item <?php echo $class; ?>" id="<?php echo $group; ?>" data-custom="<?php echo $custom;?>" data-object-id="<?php echo $object_id;?>" data-scope="<?php echo $scope;?>" data-group="<?php echo $group;?>"><?php echo $settings['label']; ?></a>
						<?php
							}
						}
						if ( is_array( $high_priority_tabs ) and !empty( $high_priority_tabs ) and is_array( $core_priority_tabs ) and !empty( $core_priority_tabs ) ) {
							?>
							<div class="separator"></div>
							<?php
						}

						foreach ( $core_priority_tabs as $group => $settings ) {
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
							if ( isset ( $settings['custom'] ) ) {
								$custom = $settings['custom'];
							} else {
								$custom = false;
							}

							if ( isset ( $settings['display_link'] ) and $settings['display_link'] ) {
						?>
						<a href="#<?php echo $group;?>" class="media-menu-item <?php echo $class; ?>" id="<?php echo $group; ?>" title="<?php echo $desc;?>" data-custom="<?php echo $custom;?>" data-object-id="<?php echo $object_id;?>" data-scope="<?php echo $scope;?>" data-group="<?php echo $group;?>"><?php echo $settings['label']; ?></a>
						<?php
							}
						}

						if ( is_array( $core_priority_tabs ) and !empty( $core_priority_tabs ) and is_array( $default_priority_tabs ) and !empty( $default_priority_tabs ) ) {
							?>
							<div class="separator"></div>
							<?php
						}
						foreach( $default_priority_tabs as $group => $settings ){
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
							if ( isset ( $settings['custom'] ) ) {
								$custom = $settings['custom'];
							} else {
								$custom = false;
							}

							if ( isset ( $settings['display_link'] ) and $settings['display_link'] ) {
						?>
						<a href="#<?php echo $group;?>" class="media-menu-item <?php echo $class; ?>" id="<?php echo $group; ?>" title="<?php echo $desc;?>" data-custom="<?php echo $custom;?>" data-object-id="<?php echo $object_id;?>" data-scope="<?php echo $scope;?>" data-group="<?php echo $group;?>"><?php echo $settings['label']; ?></a>
						<?php
							}
						}

						if ( is_array( $default_priority_tabs ) and !empty( $default_priority_tabs ) and is_array( $low_priority_tabs ) and !empty ( $low_priority_tabs ) ) {
							?>
							<div class="separator"></div>
							<?php
						}
						foreach( $low_priority_tabs as $group => $settings ){
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
							if ( isset ( $settings['custom'] ) ) {
								$custom = $settings['custom'];
							} else {
								$custom = false;
							}

							if ( isset ( $settings['display_link'] ) and $settings['display_link'] ) {
						?>
						<a href="#<?php echo $group;?>" class="media-menu-item <?php echo $class; ?>" id="<?php echo $group; ?>" title="<?php echo $desc;?>" data-custom="<?php echo $custom;?>" data-object-id="<?php echo $object_id;?>" data-scope="<?php echo $scope;?>" data-group="<?php echo $group;?>"><?php echo $settings['label']; ?></a>
						<?php
							}
						}
						?>
					</div>
				</div>
				<div class="nf-settings-non-modal">
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
  		<?php
	}

	/**
	 * Render the backbone (underscore) template for a given group.
	 * 
	 * @access private
	 * @param array $groups
	 * @since 3.0
	 * @return void
	 */

	private function get_backbone_template( $scope, $groups, $object_id ) {
		?>
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
							<label for="<%= setting.id %>">
								<%= setting.get('label') %>
							</label>
						</th>
						<td>
							<input type="checkbox" id="<%= setting.id %>" class="<%= setting.get('class') %> form-setting" value="1" <% if ( value == 1 ) { %>checked<%}%>>
							<span class="howto">
								<%= setting.get('desc') %>
							</span>
						</td>
						<%
						break;
					case 'dropdown':
						%>
						<th>
							<label for="<%= setting.id %>">
								<%= setting.get('label') %>
							</label>
						</th>
						<td>
							<select id="<%= setting_id %>" class="<%= setting.get('class') %> form-setting" data-meta-key="<%= setting.get( 'meta_key' )%>" data-object-id="<%= setting.get( 'object_id' ) %>">
							<%
							_.each(setting.get('options'), function(option) {
								%>
								<option value="<%= option.value %>" <% if ( value == option.value ) { %> selected <% } %>><%= option.name %></option>
								<%
							});
							%>
							</select>
							<span class="howto">
								<%= setting.get('desc') %>
							</span>
						</td>
						<%
						break;
					case 'number':
						%>
						<th>
							<label for="<%= setting.id %>">
								<%= setting.get('label') %>
							</label>
						</th>
						<td>
							<input type="number" id="<%= setting_id %>" class="<%= setting.get('class') %> form-setting" value="<%= value %>" min="<%= setting.get('min') %>" max="<%= setting.get('max') %>"/>
							<span class="howto">
								<%= setting.get('desc') %>
							</span>
						</td>
						<%
						break;
					case 'radio':
						%>
						<th>
							<span>
								<%= setting.get('label') %>
							</span>
						</th>
						<td>
							<%
							var x = 0;
							_.each(setting.get('options'), function(option) {
								%>
								<label>
									<input type="radio" name="<%= setting.id %>" value="<%= option.value %>" <% if ( value == option.value ) { %> checked <% } %> id="<%= setting_id %>" class="<%= setting.get('class') %> form-setting" />
									<%= option.name %>
								</label>
								<%
								x++;
							});
							%>
							</select>
							<span class="howto">
								<%= setting.get('desc') %>
							</span>
						</td>
						<%
						break;
					case 'text':
						%>
						<th>
							<label for="<%= setting.id %>">
								<%= setting.get('label') %>
							</label>
						</th>
						<td>
							<input type="text" id="<%= setting_id %>" class="<%= setting.get('class') %> form-setting" value="<%= value %>" />
							<span class="howto">
								<%= setting.get('desc') %>
							</span>
						</td>
						<%
						break;					
					case 'textarea':
						%>
						<th colspan="2">
							<label for="<%= setting.id %>">
								<%= setting.get('label') %>
							</label>
							<textarea id="<%= setting_id %>" class="<%= setting.get('class') %> form-setting"><%= value %></textarea>
							<span class="howto">
								<%= setting.get('desc') %>
							</span>
						</th>
						<%
						break;
					case 'repeater-text':

						%>
						<th>
							<label for="<%= setting.id %>">
								<%= setting.get('label') %> <a href="#" id="<%= setting_id %>" class="repeater-add">Add New</a> <br />
							</label>
						</th>
						<td>
							<span id="<%= setting_id %>_span">
								<%
								if ( typeof value === 'object' ) {
									_.each(value, function(val) {
										%>
										<span>
											<input type="text" id="" class="<%= setting.get('class') %> repeater-<%= setting_id %> repeater-text form-setting" value="<%= val %>" data-group="<%= setting_id %>" /> - <a href="#" id="<%= setting_id %>" class="repeater-remove">X</a>
											<br />
										</span>
										<%
									});
								} else {
									%>
									<span>
										<input type="text" id="" class="<%= setting.get('class') %> repeater-<%= setting_id %> repeater-text form-setting" value="" data-group="<%= setting_id %>" /> - <a href="#" id="<%= setting_id %>" class="">X</a>
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
								<%= setting.get('label') %>
							</label>
							<div id="<%= setting_id %>_replace"></div>
							<span class="howto">
								<%= setting.get('desc') %>
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
		// Loop through our tabs to see if we have any custom settings. If we do, output the template for that tab.
		foreach ( $groups as $slug => $data ) {
			foreach ( $data['settings'] as $id => $setting ) {
				if ( isset ( $setting['custom'] ) and $setting['custom'] ) {
					?>
					<script type="text/html" id="tmpl-<?php echo $slug;?>">
						<?php echo $data['template'];?>
					</script>
					<?php
				}
			}
		}

		?>
		<div id="hidden_editor_div" class="hidden">
			<?php wp_editor( 'hidden_editor', 'hidden_editor', array( 'editor_class' => 'form-setting') ); ?>
		</div>
		<?php
	}

	public function default_admin_pages() {
		$args = array(
			'page_title' 	=>	'Settings',
			'menu_title'	=> 	'Settings',
			'menu_slug'		=>	'general',
			'scope' 		=> 	'plugin_settings'
		);
		$this->register_admin_page( $args );

		global $version_compare;

		$plugin_settings = get_option("ninja_forms_settings");
		if(isset($plugin_settings['date_format'])){
			$date_format = $plugin_settings['date_format'];
		}else{
			$date_format = 'm/d/Y';
		}

		wp_enqueue_script( 'jquery-modal',
		NINJA_FORMS_URL .'/js/min/jquery.modal.min.js',
		array( 'jquery', 'jquery-ui-core' ) );


		$date_format = ninja_forms_date_to_datepicker($date_format);

		wp_enqueue_script('ninja-forms-admin',
		NINJA_FORMS_URL .'/js/dev/ninja-forms-admin.js',
		array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-datepicker', 'jquery-ui-draggable', 'jquery-ui-droppable', 'backbone' ));

		wp_localize_script( 'ninja-forms-admin', 'ninja_forms_settings', array('date_format' => $date_format));
		if ( isset ( $_REQUEST['form_id'] ) ) {
			$form_id = $_REQUEST['form_id'];
		} else {
			$form_id = '';
		}
		wp_localize_script( 'ninja-forms-admin', 'form_id', $form_id );
		wp_localize_script( 'ninja-forms-admin', 'admin_url', admin_url( 'admin.php' ) );

		wp_enqueue_script('ninja-forms-edit-form',
			NINJA_FORMS_URL .'/js/dev/edit-form.js',
			array( 'jquery', 'ninja-forms-admin' ) );
		wp_localize_script( 'ninja-forms-edit-form', 'ninja_forms_rest_url', admin_url( 'admin.php?page=ninja-forms' ) );

		ninja_forms_admin_css();
	}
}