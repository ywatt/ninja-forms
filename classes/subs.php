<?php
/**
 * Submissions.
 * This class handles storing, retrieving, editing submissions.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Submissions
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

class NF_Subs {

	/**
	 * @var sub_id store our current sub id
	 */
	var $sub_id;

	/**
	 * Get things started
	 * 
	 * @access public
	 * @since 3.0
	 * @return void/
	 */
	public function __construct() {
		// Include our submission files.
		$this->includes();
		// Start our custom post type class
		$this->CPT = new NF_Subs_CPT();

	}

	/**
	 * Include our submission-related files
	 * 
	 * @access private
	 * @since 3.0
	 * @return void
	 */
	private function includes() {
		// Include our subs CPT
		require_once( NF_PLUGIN_DIR . 'classes/subs-cpt.php' );
	}

	/**
	 * Set our current submission id
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function set_sub( $sub_id ) {
		$this->sub_id = $sub_id;
	}

	/**
	 * Create a submission.
	 * 
	 * @access public
	 * @since 3.0
	 * @return int $sub_id
	 */
	public function create_sub() {
		echo "Create Sub";
	}

	/**
	 * Add a submitted value to our submission.
	 * 
	 * @access public
	 * @since 3.0
	 * @return bool
	 */
	public function add_value( $field_id, $value ) {
		echo "SUB ID: " . $this->sub_id;
	}

	/**
	 * Get a submission from the database
	 * 
	 * @access public
	 * @since 3.0
	 * @return array $sub
	 */
	public function get_sub() {
		echo "GET SUB";
	}

}