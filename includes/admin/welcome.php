<?php
/**
 * About Page Class
 *
 * @package     NF
 * @subpackage  Admin/Welcome
 * @copyright   Copyright (c) 2014, WP Ninjas
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.7
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * NF_Welcome Class
 *
 * A general class for About and Credits page.
 *
 * @since 1.4
 */
class NF_Welcome {

	/**
	 * @var string The capability users should have to view the page
	 */
	public $minimum_capability = 'manage_options';

	/**
	 * Get things started
	 *
	 * @since 1.4
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menus') );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'admin_init', array( $this, 'welcome'    ) );
	}

	/**
	 * Register the Dashboard Pages which are later hidden but these pages
	 * are used to render the Welcome and Credits pages.
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function admin_menus() {
		// About Page
		add_dashboard_page(
			__( 'Welcome to Ninja Forms', 'ninja-forms' ),
			__( 'Welcome to Ninja Forms', 'ninja-forms' ),
			$this->minimum_capability,
			'nf-about',
			array( $this, 'about_screen' )
		);

		// Changelog Page
		add_dashboard_page(
			__( 'Ninja Forms Changelog', 'ninja-forms' ),
			__( 'Ninja Forms Changelog', 'ninja-forms' ),
			$this->minimum_capability,
			'nf-changelog',
			array( $this, 'changelog_screen' )
		);

		// Getting Started Page
		add_dashboard_page(
			__( 'Getting started with Ninja Forms', 'ninja-forms' ),
			__( 'Getting started with Ninja Forms', 'ninja-forms' ),
			$this->minimum_capability,
			'nf-getting-started',
			array( $this, 'getting_started_screen' )
		);

		// Credits Page
		add_dashboard_page(
			__( 'The people that build Ninja Forms', 'ninja-forms' ),
			__( 'The people that build Ninja Forms', 'ninja-forms' ),
			$this->minimum_capability,
			'nf-credits',
			array( $this, 'credits_screen' )
		);
	}

	/**
	 * Hide Individual Dashboard Pages
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function admin_head() {
		remove_submenu_page( 'index.php', 'nf-about' );
		remove_submenu_page( 'index.php', 'nf-changelog' );
		remove_submenu_page( 'index.php', 'nf-getting-started' );
		remove_submenu_page( 'index.php', 'nf-credits' );

		// Badge for welcome page
		$badge_url = NF_PLUGIN_URL . 'assets/images/nf-badge.png';
		?>
		<style type="text/css" media="screen">
		/*<![CDATA[*/
		.nf-badge {
			padding-top: 150px;
			height: 52px;
			width: 185px;
			color: #666;
			font-weight: bold;
			font-size: 14px;
			text-align: center;
			text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8);
			margin: 0 -5px;
			background: url('<?php echo $badge_url; ?>') no-repeat;
		}

		.about-wrap .nf-badge {
			position: absolute;
			top: 0;
			right: 0;
		}

		.nf-welcome-screenshots {
			float: right;
			margin-left: 10px!important;
		}

		.about-wrap .feature-section {
			margin-top: 20px;
		}

		/*]]>*/
		</style>
		<?php
	}

	/**
	 * Navigation tabs
	 *
	 * @access public
	 * @since 1.9
	 * @return void
	 */
	public function tabs() {
		$selected = isset( $_GET['page'] ) ? $_GET['page'] : 'nf-about';
		?>
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php echo $selected == 'nf-about' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'nf-about' ), 'index.php' ) ) ); ?>">
				<?php _e( "What's New", 'ninja-forms' ); ?>
			</a>
			<a class="nav-tab <?php echo $selected == 'nf-getting-started' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'nf-getting-started' ), 'index.php' ) ) ); ?>">
				<?php _e( 'Getting Started', 'ninja-forms' ); ?>
			</a>
			<a class="nav-tab <?php echo $selected == 'nf-credits' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'nf-credits' ), 'index.php' ) ) ); ?>">
				<?php _e( 'Credits', 'ninja-forms' ); ?>
			</a>
		</h2>
		<?php
	}

	/**
	 * Render About Screen
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function about_screen() {
		list( $display_version ) = explode( '-', NF_PLUGIN_VERSION );
		?>
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to Ninja Forms %s', 'ninja-forms' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for updating to the latest version! Ninja Forms %s is ready to make your online store faster, safer, and better!', 'ninja-forms' ), $display_version ); ?></div>
			<div class="nf-badge"><?php printf( __( 'Version %s', 'ninja-forms' ), $display_version ); ?></div>

			<?php $this->tabs(); ?>

			<div class="changelog">
				<h3><?php _e( 'Sequential Submission Numbers', 'ninja-forms' );?></h3>

				<div class="feature-section">

					<img src="<?php echo NF_PLUGIN_URL . 'assets/images/screenshots/20-sequential.png'; ?>" class="nf-welcome-screenshots"/>

					<h4><?php _e( 'Prefix, Postfix, and Starting Number', 'ninja-forms' );?></h4>
					<p><?php printf( __( 'Sequential order numbers are now supported out of the box. Simply go to <a href="%s">Settings &rarr; Misc</a> to enable them. The starting number, prefix, and postfix for order numbers can all be easily configured.', 'ninja-forms' ), admin_url( 'edit.php?post_type=download&page=nf-settings&tab=misc' ) ); ?></p>

					<h4><?php _e( 'Upgrade Routine', 'ninja-forms' );?></h4>
					<p><?php _e( 'Sequential order numbers are important for some and even mandatory for others, so we want to ensure that all users can make use of them. For this reason, we have provided a one-click upgrade routine that will update all previous purchase records with sequential order numbers matching your settings.', 'ninja-forms' );?></p>

				</div>
			</div>

			<div class="return-to-dashboard">
				<a href="<?php echo esc_url( admin_url( 'index.php?page=ninja-forms' ) ); ?>"><?php _e( 'Return to Ninja Forms', 'ninja-forms' ); ?></a> &middot;
				<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'nf-changelog' ), 'index.php' ) ) ); ?>"><?php _e( 'View the Full Changelog', 'ninja-forms' ); ?></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Changelog Screen
	 *
	 * @access public
	 * @since 2.0.3
	 * @return void
	 */
	public function changelog_screen() {
		list( $display_version ) = explode( '-', NF_PLUGIN_VERSION );
		?>
		<div class="wrap about-wrap">
			<h1><?php _e( 'Ninja Forms Changelog', 'ninja-forms' ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for updating to the latest version! Ninja Forms %s is ready to make your online store faster, safer, and better!', 'ninja-forms' ), $display_version ); ?></div>
			<div class="nf-badge"><?php printf( __( 'Version %s', 'ninja-forms' ), $display_version ); ?></div>

			<?php $this->tabs(); ?>

			<div class="changelog">
				<h3><?php _e( 'Full Changelog', 'ninja-forms' );?></h3>

				<div class="feature-section">
					<?php echo $this->parse_readme(); ?>
				</div>
			</div>

			<div class="return-to-dashboard">
				<a href="<?php echo esc_url( admin_url( 'index.php?page=ninja-forms' ) ); ?>"><?php _e( 'Go to Ninja Forms', 'ninja-forms' ); ?></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Getting Started Screen
	 *
	 * @access public
	 * @since 1.9
	 * @return void
	 */
	public function getting_started_screen() {
		list( $display_version ) = explode( '-', NF_PLUGIN_VERSION );
		?>
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to Ninja Forms %s', 'ninja-forms' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for updating to the latest version! Ninja Forms %s is ready to make your online store faster, safer and better!', 'ninja-forms' ), $display_version ); ?></div>
			<div class="nf-badge"><?php printf( __( 'Version %s', 'ninja-forms' ), $display_version ); ?></div>

			<?php $this->tabs(); ?>

			<p class="about-description"><?php _e( 'Use the tips below to get started using Ninja Forms. You will be up and running in no time!', 'ninja-forms' ); ?></p>

			<div class="changelog">
				<h3><?php _e( 'Creating Your First Download Product', 'ninja-forms' );?></h3>

				<div class="feature-section">

					<img src="<?php echo NF_PLUGIN_URL . 'assets/images/screenshots/edit-download.png'; ?>" class="nf-welcome-screenshots"/>

					<h4><?php __( '<a href="">%s &rarr; Add New</a>', 'ninja-forms' ); ?></h4>
					<p><?php __( 'The forms menu is your access point for all aspects of your Ninja Forms product creation and setup. To create your first product, simply click Add New and then fill out the product details.', 'ninja-forms' ); ?></p>

					<h4><?php _e( 'Product Price', 'ninja-forms' );?></h4>
					<p><?php _e( 'Products can have simple prices or variable prices if you wish to have more than one price point for a product. For a single price, simply enter the price. For multiple price points, click <em>Enable variable pricing</em> and enter the options.', 'ninja-forms' );?></p>

					<h4><?php _e( 'Download Files', 'ninja-forms' );?></h4>
					<p><?php _e( 'Uploading the downloadable files is simple. Click <em>Upload File</em> in the Download Files section and choose your download file. To add more than one file, simply click the <em>Add New</em> button.', 'ninja-forms' );?></p>

				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Credits Screen
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function credits_screen() {
		list( $display_version ) = explode( '-', NF_PLUGIN_VERSION );
		?>
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to Ninja Forms %s', 'ninja-forms' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for updating to the latest version! Ninja Forms %s is ready to make your online store faster, safer and better!', 'ninja-forms' ), $display_version ); ?></div>
			<div class="nf-badge"><?php printf( __( 'Version %s', 'ninja-forms' ), $display_version ); ?></div>

			<?php $this->tabs(); ?>

			<p class="about-description"><?php _e( 'Ninja Forms is created by a worldwide team of developers who aim to provide the #1 eCommerce platform for selling digital goods through WordPress.', 'ninja-forms' ); ?></p>

			<?php echo $this->contributors(); ?>
		</div>
		<?php
	}


	/**
	 * Parse the NF readme.txt file
	 *
	 * @since 2.0.3
	 * @return string $readme HTML formatted readme file
	 */
	public function parse_readme() {
		$file = file_exists( NF_PLUGIN_DIR . 'readme.txt' ) ? NF_PLUGIN_DIR . 'readme.txt' : null;

		if ( ! $file ) {
			$readme = '<p>' . __( 'No valid changlog was found.', 'ninja-forms' ) . '</p>';
		} else {
			$readme = file_get_contents( $file );
			$readme = nl2br( esc_html( $readme ) );

			$readme = end( explode( '== Changelog ==', $readme ) );

			$readme = preg_replace( '/`(.*?)`/', '<code>\\1</code>', $readme );
			$readme = preg_replace( '/[\040]\*\*(.*?)\*\*/', ' <strong>\\1</strong>', $readme );
			$readme = preg_replace( '/[\040]\*(.*?)\*/', ' <em>\\1</em>', $readme );
			$readme = preg_replace( '/= (.*?) =/', '<h4>\\1</h4>', $readme );
			$readme = preg_replace( '/\[(.*?)\]\((.*?)\)/', '<a href="\\2">\\1</a>', $readme );
		}

		return $readme;
	}


	/**
	 * Render Contributors List
	 *
	 * @since 1.4
	 * @uses NF_Welcome::get_contributors()
	 * @return string $contributor_list HTML formatted list of all the contributors for NF
	 */
	public function contributors() {
		$contributors = $this->get_contributors();

		if ( empty( $contributors ) )
			return '';

		$contributor_list = '<ul class="wp-people-group">';

		foreach ( $contributors as $contributor ) {
			$contributor_list .= '<li class="wp-person">';
			$contributor_list .= sprintf( '<a href="%s" title="%s">',
				esc_url( 'https://github.com/' . $contributor->login ),
				esc_html( sprintf( __( 'View %s', 'ninja-forms' ), $contributor->login ) )
			);
			$contributor_list .= sprintf( '<img src="%s" width="64" height="64" class="gravatar" alt="%s" />', esc_url( $contributor->avatar_url ), esc_html( $contributor->login ) );
			$contributor_list .= '</a>';
			$contributor_list .= sprintf( '<a class="web" href="%s">%s</a>', esc_url( 'https://github.com/' . $contributor->login ), esc_html( $contributor->login ) );
			$contributor_list .= '</a>';
			$contributor_list .= '</li>';
		}

		$contributor_list .= '</ul>';

		return $contributor_list;
	}

	/**
	 * Retreive list of contributors from GitHub.
	 *
	 * @access public
	 * @since 1.4
	 * @return array $contributors List of contributors
	 */
	public function get_contributors() {
		$contributors = get_transient( 'nf_contributors' );

		if ( false !== $contributors )
			return $contributors;

		$response = wp_remote_get( 'https://api.github.com/repos/wpninjas/ninja-forms/contributors', array( 'sslverify' => false ) );

		if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) )
			return array();

		$contributors = json_decode( wp_remote_retrieve_body( $response ) );

		if ( ! is_array( $contributors ) )
			return array();

		set_transient( 'nf_contributors', $contributors, 3600 );

		return $contributors;
	}

	/**
	 * Sends user to the Welcome page on first activation of NF as well as each
	 * time NF is upgraded to a new version
	 *
	 * @access public
	 * @since 1.4
	 * @global $nf_options Array of all the NF Options
	 * @return void
	 */
	public function welcome() {
		global $nf_options;

		// Bail if no activation redirect
		if ( ! get_transient( '_nf_activation_redirect' ) )
			return;

		// Delete the redirect transient
		delete_transient( '_nf_activation_redirect' );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) )
			return;

		$upgrade = get_option( 'nf_version_upgraded_from' );

		if( ! $upgrade ) { // First time install
			wp_safe_redirect( admin_url( 'index.php?page=nf-getting-started' ) ); exit;
		} else { // Update
			wp_safe_redirect( admin_url( 'index.php?page=nf-about' ) ); exit;
		}
	}
}
new NF_Welcome();
