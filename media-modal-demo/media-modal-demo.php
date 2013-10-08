<?php
/**
 * Don't call this file directly.
 */
if ( ! class_exists( 'WP' ) ) {
	die();
}

/**
 * The base class.
 */
class Media_Modal_Demo {
	/**
	 * Stores the class instance.
	 *
	 * @var Media_Modal_Demo
	 */
	private static $instance = null;

	/**
	 * Stores the current demo page number.
	 *
	 * @var integer
	 */
	private $current_demo_page = 5;

	/**
	 * Stores the class instance of the current demo
	 *
	 * @var Media_Modal_Demo_Page_Abstract
	 */
	private $demo_page_instance = null;

	/**
	 * Stores the hook suffix of the screen.
	 *
	 * @var string
	 */
	private $screen_id = '';

	/**
	 * Stores the classes which will be autoloaded.
	 *
	 * Class name => path to class, relative to __FILE__
	 *
	 * @var array
	 */
	public static $demo_classes = array(
		'Media_Modal_Demo_Page_Abstract' => 'demos',
		'Media_Modal_Demo_Page_5'        => 'demos/demo-5',
	);

	/**
	 * Returns the instance of this class.
	 *
	 * It's a singleton class.
	 *
	 * @return Media_Modal_Demo The instance
	 */
	public static function get_instance() {
		if ( ! self::$instance )
			self::$instance = new self;

		return self::$instance;
	}

	/**
	 * Initialises the plugin.
	 *
	 * Returns false if not in admin. Sets the spl_autoload_register
	 * callback.
	 */
	public function init_plugin() {
		if ( ! is_admin() )
			return false;

		spl_autoload_register( 'Media_Modal_Demo::autoloader' );

		$this->set_current_demo_page_number();

		$this->set_demo_page_instance();

		$this->init_hooks();
	}

	/**
	 * Sets the current demo page number either by argument
	 * or by the value of $_GET[ 'demo' ].
	 *
	 * @param integer $page The demo page number
	 */
	public function set_current_demo_page_number( $page = 5 ) {
		if ( ! empty( $page ) )
			$this->current_demo_page_number = $page;
		else
			$this->current_demo_page_number = ! empty( $_GET[ 'demo' ] ) ? (int) $_GET[ 'demo' ] : 1;
	}

	/**
	 * Returns the current demo page number.
	 *
	 * @return integer The demo page number
	 */
	public function get_current_demo_page_number() {
		return $this->current_demo_page_number;
	}

	/**
	 * Sets the instance of the current demo page class. Either
	 * by argument or $current_demo_page.
	 * Dies if class doesn't exist.
	 *
	 * @param string $class A custom class name
	 */
	public function set_demo_page_instance( $class = null ) {
		if ( empty( $class ) ) {
			$class = sprintf(
				'Media_Modal_Demo_Page_%d',
				$this->current_demo_page_number
			);
		}

		if ( class_exists( $class ) )
			$this->demo_page_instance = new $class;
		else
			wp_die( "Sorry, but this demo doesn't exist!" );
	}

	/**
	 * Returns the instance of the current demo page class.
	 *
	 * @return Media_Modal_Demo_Page_Abstract The instance of the class
	 */
	public function get_demo_page_instance() {
		return $this->demo_page_instance;
	}

	/**
	 * Initialises the WP actions.
	 *  - admin_menu
	 *  - admin_print_scripts
	 *  - admin_print_styles
	 *
	 * Initialises also the hooks of the demo page class.
	 */
	private function init_hooks() {
		add_action( 'admin_menu', array( $this, 'add_plugins_page' ) );

		add_action( 'admin_print_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_print_styles', array( $this, 'enqueue_styles' ) );

		$this->demo_page_instance->init_hooks();
	}

	/**
	 * Adds a menu entry for this plugin.
	 */
	public function add_plugins_page() {
		$this->screen_id = add_submenu_page(
			'ninja-forms',
			'Modal Demo',
			'Modal Demo',
			'manage_options',
			'ninja-forms-modal-demo',
			array( $this, 'render_page' )
		);

	}

	/**
	 * Enqueues the scripts and calls wp_enqueue_media().
	 *
	 * Calls also the enqueue method of the demo page class.
	 */
	public function enqueue_scripts() {
		if ( ! isset( get_current_screen()->id ) || get_current_screen()->id != $this->screen_id )
			return;

		wp_enqueue_media();

		$this->demo_page_instance->enqueue_scripts();
	}

	/**
	 * Enqueues the styles.
	 *
	 * Calls also the enqueue method of the demo page class.
	 */
	public function enqueue_styles() {
		if ( ! isset( get_current_screen()->id ) || get_current_screen()->id != $this->screen_id )
			return;

		wp_enqueue_style(
			'media-modal-demo',
			plugins_url( 'css/media-modal-demo.css', __FILE__ ),
			array( 'media-views' )
		);

		$this->demo_page_instance->enqueue_styles();
	}

	/**
	 * Renders the page.
	 *
	 * Calls also the methods of the demo page class.
	 */
	public function render_page() {
		?>
		<div id="media-modal-demo" class="wrap">
			<h2>Media Modal Demo</h2>

			<div id="media-modal-demo-content">
				<?php $this->demo_page_instance->render_content(); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * The callback function for the autoloader.
	 *
	 * @param  string $class The class name
	 */
	public static function autoloader( $class ) {
		if ( in_array( $class, array_keys( self::$demo_classes ) ) ) {
			require_once(
				sprintf(
					'%s/%s/class-%s.php',
					dirname( __FILE__ ),
					self::$demo_classes[ $class ],
					strtolower( str_replace( '_', '-', $class ) )
				)
			);
		}
	}
}

// We are now ready for take off
add_action( 'init', array( Media_Modal_Demo::get_instance(), 'init_plugin' ), 20 );
