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
	 * @var plugin_settings
	 * @since 3.0
	 */
	public $plugin_settings;

	/**
	 * @var tabs
	 * @since 3.0
	 */
	public $tabs;

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

		$this->license = new NF_License();

		// add admin menus
		add_action( 'admin_menu', array( $this, 'add_menu_page' ) );

		// add our settings via the options API
		add_action( 'admin_init', array( $this, 'add_plugin_settings' ) );
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
	 * Add our admin menu items
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function add_menu_page() {
		$page = add_menu_page( __( 'Ninja Forms', 'ninja-forms' ) , __( 'Ninja Forms', 'ninja-forms' ), apply_filters( 'nf_admin_menu_capabilities', 'manage_options' ), 'ninja-forms', array( $this, 'all_forms' ), NF_PLUGIN_URL . "assets/images/nf-ico-small.png", "35.1337" );
		//add_action( 'admin_print_styles-' . $page, array( $this, 'admin_css' ) );

		$sub_page = add_submenu_page( 'ninja-forms', __( 'Ninja Forms', 'ninja-forms' ) , __( 'All Forms', 'ninja-forms' ), apply_filters( 'nf_admin_menu_capabilities', 'manage_options' ), 'ninja-forms' );
		//add_action( 'admin_print_styles-' . $sub_page, array( $this, 'admin_css' ) );
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
		wp_enqueue_script( 'nf-admin', NF_PLUGIN_URL . 'assets/js/dev/admin.js', array( 'jquery', 'jquery-ui-datepicker' ) );
	}

	/**
	 * Output our admin page
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function all_forms() {

		echo "RENDER A FORM";
		//Ninja_Forms()->form( 1 )->update_setting( 'name', 'Your First Name' );
		Ninja_Forms()->form( 1 )->render();

		echo "<br><br><br>";
		echo "RENDER A FIELD BY KEY NAME";

		Ninja_Forms()->form( 1 )->field( 'firstname' )->render();

		echo "<br><br><br>";
		echo "GET A FIELD SETTING BY KEY NAME: ";
		echo "<strong>";

		print_r( Ninja_Forms()->form( 1 )->field( 'firstname' )->get_setting( 'label' ) );
		echo "</strong>";

		var_dump( Ninja_Forms()->field( 9 )->get_value() );
	}

	/**
	 * Get our tabs
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