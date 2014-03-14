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
		add_action( 'admin_menu', 'nf_register_default_admin_pages' );
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
			'capabilities' 	=> 	apply_filters( 'ninja_forms_admin_menu_capabilities', 'manage_options' ),
			'menu_slug'		=>	'',
			'function' 		=>	array( $this, 'render_page' ),
			'scope'			=> 	'',
			'object_id'		=> 	0,
			'js'			=> '',
		);

		// Parse incomming $args into an array and merge it with $defaults
		$args = wp_parse_args( $args, $defaults );

		if ( $args['menu_slug'] == '' ) {
			$args['menu_slug'] = sanitize_title( $args['menu_title'] );
		}

		$this->pages[ $args['menu_slug'] ] = $args;

		$page = add_submenu_page( $args['parent_slug'], __( $args['page_title'], 'ninja-forms' ), __( $args['menu_title'], 'ninja-forms' ), $args['capabilities'], $args['menu_slug'], array( $this, 'render_page') );
		//add_action('admin_print_styles-' . $page, 'ninja_forms_admin_css');
		add_action( 'admin_print_styles-' . $page, array( $this, 'admin_js' ) );
		if ( function_exists( $args['js'] ) ) {
			add_action( 'admin_print_styles-' . $page, $args['js'] );
		} else {
			add_action( 'admin_print_styles-' . $page, array( $this, 'settings_js' ) );
		}
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
			echo $this->get_admin_template( $scope, $groups, $object_id );
			echo $this->get_backbone_template( $scope, $groups, $object_id );
		}
	}

	/**
	 * Render the admin page
	 * 
	 * @access private
	 * @param array $groups
	 * @since 3.0
	 * @return string $html
	 */

	public function get_admin_template( $scope, $groups, $object_id ) {

		$html = '<div id="" style="">
		  	<div class="" id="">
		  		' . $this->get_sidebar_template( $scope, $groups, $object_id ) . '
				<div class="nf-settings">
					<div class="nf-settings-title">
						<h1></h1>
						<div class="updated" style="display:none"></div>
					</div>
					<div class="nf-settings-desc-desc"></div>
					<div class="nf-settings-content-wrap">
						<div class="nf-settings-content" id="nf-settings-content">
						</div>
					</div>
				</div>
			</div>
  		</div>';

  		return apply_filters( 'nf_admin_template', $html );
	}

	/**
	 * Render the sidebar HTML for our admin page.
	 * 
	 * @access public
	 * @param array $groups
	 * @since 3.0
	 * @return string $html
	 */

	function get_sidebar_template( $scope, $groups, $object_id ) {
		
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
		$html = '<div class="media-frame-menu">
			<div class="media-menu">';
				if ( is_array( $high_priority_tabs ) and !empty( $high_priority_tabs ) ) {
					$html .= '<div class="separator"></div>';
				}
				$active = false;
				foreach( $high_priority_tabs as $group => $settings ){
					$link = $this->get_sidebar_link( $scope, $group, $object_id, $settings, $active );
					$active = $link['active'];
					$html .= $link['html'];
				}
				if ( is_array( $high_priority_tabs ) and !empty( $high_priority_tabs ) and is_array( $core_priority_tabs ) and !empty( $core_priority_tabs ) ) {
						$html .= '<div class="separator"></div>';
				}

				foreach ( $core_priority_tabs as $group => $settings ) {
					$link = $this->get_sidebar_link( $scope, $group, $object_id, $settings, $active );
					$active = $link['active'];
					$html .= $link['html'];
				}

				if ( is_array( $core_priority_tabs ) and !empty( $core_priority_tabs ) and is_array( $default_priority_tabs ) and !empty( $default_priority_tabs ) ) {
					$html .= '<div class="separator"></div>';
				}
				foreach( $default_priority_tabs as $group => $settings ){
					$link = $this->get_sidebar_link( $scope, $group, $object_id, $settings, $active );
					$active = $link['active'];
					$html .= $link['html'];
				}

				if ( is_array( $default_priority_tabs ) and !empty( $default_priority_tabs ) and is_array( $low_priority_tabs ) and !empty ( $low_priority_tabs ) ) {
					$html .= '<div class="separator"></div>';
				}
				foreach( $low_priority_tabs as $group => $settings ){
					$link = $this->get_sidebar_link( $scope, $group, $object_id, $settings, $active );
					$active = $link['active'];
					$html .= $link['html'];
				}

			$html .= '</div>
		</div>';

		return apply_filters( 'nf_admin_sidebar_template', $html );
	}

	/**
	 * Render the backbone (underscore) template for a given group.
	 * 
	 * @access private
	 * @param array $groups
	 * @since 3.0
	 * @return void
	 */

	public function get_backbone_template( $scope, $groups, $object_id ) {
		ob_start();
		?>
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
								<%= setting.get('label') %>
							</label>
						</th>
						<td>
							<input type="checkbox" id="<%= setting.id %>" class="<%= setting.get('class') %> nf-setting" value="1" <% if ( value == 1 ) { %>checked<%}%> <%= data_attributes %>>
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
								<%= setting.get('desc') %>
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
								<%= setting.get('label') %>
							</label>
						</th>
						<td>
							<input type="number" id="<%= setting_id %>" class="<%= setting.get('class') %> nf-setting" value="<%= value %>" min="<%= setting.get('min') %>" max="<%= setting.get('max') %>"  <%= data_attributes %>/>
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
									<input type="radio" name="<%= setting.id %>" value="<%= option.value %>" <% if ( value == option.value ) { %> checked <% } %> id="<%= setting_id %>" class="<%= setting.get('class') %> nf-setting" <%= data_attributes %>/>
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
							<div class="nf-help">
								
							</div>
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
							<input type="text" id="<%= setting_id %>" class="<%= setting.get('class') %> nf-setting" value="<%= value %>" title="TEST TEST TEST" <%= data_attributes %>/>
							<span class="howto">
								<%= setting.get('desc') %>
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
								<%= setting.get('label') %>
							</label>
							<textarea id="<%= setting_id %>" class="<%= setting.get('class') %> nf-setting" <%= data_attributes %>><%= value %></textarea>
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
		// Loop through our groups to see if we have any custom settings. If we do, output the template for that group.
		foreach ( $groups as $slug => $data ) {
			if ( isset ( $data['template'] ) and $data['template'] != '' ) {
				?>
				<script type="text/html" id="tmpl-<?php echo $slug;?>">
					<?php echo $data['template'];?>
				</script>
				<?php
			}
		}

		?>
		<div id="hidden_editor_div" class="hidden">
			<?php wp_editor( 'hidden_editor', 'hidden_editor', array( 'editor_class' => 'nf-setting') ); ?>
		</div>
		<?php

		$tmpl = ob_get_clean();
		return apply_filters( 'nf_admin_backbone_template', $tmpl );
	}

	/**
	 * Output our sidebar link
	 * 
	 * @since 3.0
	 * @param $settings
	 * @return $html
	 */

	private function get_sidebar_link( $scope, $group, $object_id, $settings, $active ) {
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

		if ( isset ( $settings['template'] ) and $settings['template'] != '' ) {
			$custom_tmpl = true;
		} else {
			$custom_tmpl = false;
		}

		if ( isset ( $settings['custom_backbone'] ) and ! empty( $settings['custom_backbone'] ) ) {
			$custom_backbone = true;
		} else {
			$custom_backbone = false;
		}

		if ( isset ( $settings['display_link'] ) and $settings['display_link'] ) {
			$html = '<a href="#' . $group . '" class="media-menu-item ' . $class . ' wp-has-current-submenu" id="nf_' . $group . '_btn" title="' . $desc . '" data-custom-tmpl="' . $custom_tmpl . '" data-custom-backbone="' . $custom_backbone . '" data-object-id="' . $object_id . '" data-scope="' . $scope . '" data-group="' . $group . '">' . $settings['label'] . '</a>';
		} else {
			$html = '';
		}

		return array( 'active' => $active, 'html' => $html );
	}

	/**
	 * Include our JS files for the admin.
	 * 
	 * @since 3.0
	 * @return void
	 */

	public function admin_js() {
		global $version_compare;

		$plugin_settings = get_option("ninja_forms_settings");
		if(isset($plugin_settings['date_format'])){
			$date_format = $plugin_settings['date_format'];
		}else{
			$date_format = 'm/d/Y';
		}

		wp_enqueue_script( 'jquery-modal',
		NF_PLUGIN_URL .'js/min/jquery.modal.min.js',
		array( 'jquery', 'jquery-ui-core' ) );

		$date_format = ninja_forms_date_to_datepicker($date_format);

		wp_enqueue_script('nf-admin',
		NF_PLUGIN_URL .'js/dev/ninja-forms-admin.js',
		array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-datepicker', 'jquery-ui-draggable', 'jquery-ui-droppable', 'backbone' ));

		wp_localize_script( 'nf-admin', 'ninja_forms_settings', array('date_format' => $date_format));
		if ( isset ( $_REQUEST['form_id'] ) ) {
			$object_id = $_REQUEST['form_id'];
		} else {
			$object_id = '';
		}
		wp_localize_script( 'nf-admin', 'object_id', $object_id );
		wp_localize_script( 'nf-admin', 'admin_url', admin_url( 'admin.php' ) );
		wp_localize_script( 'nf-admin', 'nf_rest_url', admin_url( 'admin.php?page=ninja-forms' ) );

		ninja_forms_admin_css();
	}

	/**
	 * Include our JS files for the basic settings
	 * 
	 * @since 3.0
	 * @return void
	 */

	public function settings_js() {		
		wp_enqueue_script( 'nf-settings-admin',
			NF_PLUGIN_URL .'js/dev/settings-admin.js',
			array( 'nf-admin' ) );
	}
}