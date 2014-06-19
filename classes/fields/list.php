<?php
/**
 * List field class
 * This class should be extended, and isn't registered itself.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Field
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Field_List extends NF_Field_Base {

	/**
	 * @var items
	 * @since 3.0
	 */
	var $items = array();

	/**
	 * @var sidebar
	 * @var since 3.0
	 */
	var $sidebar = '';

	/**
	 * Get things started
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct();

		$this->settings_menu['items'] = __( 'Items', 'ninja-forms' );

		$item_settings = apply_filters( 'nf_list_settings', array(
			'list_items' 			=> array(
				'id' 				=> 'list_items',
				'type' 				=> 'custom',
				'name' 				=> __( 'Item', 'ninja-forms' ),
				'desc' 				=> '',
				'help_text' 		=> '',
				'std' 				=> 0,
				'template_callback'	=> array( $this, 'underscore_template' ),
				'fetch_callback'	=> array( $this, 'fetch_items' ),
			),
			'selected'				=> array(
				'id'				=> 'selected',
				'type'				=> 'custom',
				'name'				=> '',
				'desc'				=> '',
				'std'				=> array(),
			),
		) );

		$this->registered_settings['items'] = $item_settings;

		$this->registered_settings['display']['default_value']['type'] = 'custom';
		$this->registered_settings['display']['label_pos']['options'] = array(
			array( 'name' => __( 'Above Element', 'ninja-forms' ), 'value' => 'above' ),
			array( 'name' => __( 'Left of Element', 'ninja-forms' ), 'value' => 'left' ),
			array( 'name' => __( 'Right of Element', 'ninja-forms' ), 'value' => 'right' ),
			array( 'name' => __( 'Below Element', 'ninja-forms' ), 'value' => 'below' ),
		);

		do_action( 'nf_list_construct', $this );
		
	}

	/**
	 * Custom setup function. We need to 
	 * get our list of items for this list field.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function setup() {
		if ( $this->field_id != '' && ! isset ( $this->items[ $this->field_id ] ) ) {
			$this->items[ $this->field_id ] = nf_get_object_children( $this->field_id, 'list_item' );
			uasort( $this->items[ $this->field_id ], array( Ninja_Forms(), 'sort_by_order' ) );
			// Loop through and make sure that we have a set value
			foreach ( $this->items[ $this->field_id ] as $item_id => $item ) {
				if ( ! isset ( $item['value'] ) ) {
					$this->items[ $this->field_id ][ $item_id ]['value'] = '';
				}
			}
		}

		if ( $this->value == '' && isset ( $this->settings['selected'] ) ) {
			$this->value = $this->settings['selected'];
		}
	}

	/**
	 * Output our Underscore template for editing this field.
	 * 
	 * @access public
	 * @since 3.0
	 * @return void
	 */
	public function underscore_template( $field_id ) {
		?>
		</tr>
		<tbody>
			<tr>
				<th>
					<a href="#" class="button-secondary"><?php _e( 'Import List Items', 'ninja-forms' ); ?></a>
				</th>
				<th>
					Default
				</th>
				<th>
					Label
				</th>
				<th>
					Value
				</th>				
				<th>
					Calculation Amount
				</th>
			</tr>
		</tbody>
		<tbody class="nf-list-items">
			<%
			if ( typeof setting.get( 'items' ) !== 'undefined' ) {
				_.each( setting.get( 'items' ), function( item ) {
					
					if ( setting.get( 'selected' ) == item.object_id ) {
						var checked = 'checked="checked"';
					} else {
						var checked = '';
					}
				%>
				<tr class="nf-list-item" id="item_<%= item.object_id %>_tr" data-item-id=<%= item.object_id %>>
					<th>
						<a href="#" class="button-secondary nf-delete-list-item" data-item-id="<%= item.object_id %>" data-field-id="<%= setting.get( 'object_id' ) %>">-</a>
						<span class="drag" style="cursor:move;">Drag</span>
					</th>
					<td>
						<input type="radio" id="selected" class="nf-setting" name="selected" value="<%= item.object_id %>" <%= checked %>>
					</td>
					<td>
						<input type="text" id="item_<%= item.object_id %>_label" class="nf-setting" value="<%= item.label %>" title="<?php _e( 'Item Label', 'ninja-forms' ); ?>" <%= data_attributes %>/>
					</td>
					<td>
						<input type="text" id="item_<%= item.object_id %>_value" class="nf-setting" value="<%= item.value %>" title="" <%= data_attributes %>/>
					</td>
					<td>
						<input type="text" id="item_<%= item.object_id %>_calc" class="nf-setting" value="<%= item.calc %>" title="" <%= data_attributes %>/>
					</td>

				</tr>
				<%
				});
			}
			%>
			<tr class="nf-list-item-new">
				<th style="display:none;" class="list-item-actions">
					<a href="#" class="button-secondary nf-delete-list-item" data-field-id="<%= setting.get( 'object_id' ) %>">-</a>
					<span class="drag" style="cursor:move;">Drag</span>
				</th>
				<th colspan="2" class="list-item-new">
					Enter text to add a new item ->
				</th>
				<td style="display:none;" class="list-item-selected">
					<input type="radio" id="selected" class="nf-setting" name="selected" value="">
				</td>
				<td>
					<input type="text" id="item_new_label" data-parent-id="<%= setting.get( 'object_id' ) %>" data-meta-key="label" class="nf-new-item" value="" title="<?php _e( 'Item Label', 'ninja-forms' ); ?>" <%= data_attributes %>/>
				</td>
				<td>
					<input type="text" id="item_new_value" data-parent-id="<%= setting.get( 'object_id' ) %>" data-meta-key="value"  class="nf-new-item" value="" title="" <%= data_attributes %>/>
				</td>
				<td>
					<input type="text" id="item_new_calc" data-parent-id="<%= setting.get( 'object_id' ) %>" data-meta-key="calc"  class="nf-new-item" value="" title="" <%= data_attributes %>/>
				</td>

			</tr>
		</tbody>
		
		<tr>
			<th>
			</th>
			<td>
				<span class="howto">
					<%= setting.get( 'desc' ) %>
				</span>
				<div class="nf-help">
					
				</div>
			</td>
		</tr>
		<?php
	}

	/**
	 * Fetch an array of items for our edit field.
	 * 
	 * @access public
	 * @since 3.0
	 * @return array $args
	 */
	public function fetch_items( $field_id ) {

		// Get our currently selected item
		$selected = Ninja_Forms()->field( $field_id )->get_setting( 'selected' );

		/**
		 * $items_array will be an array of all of our items 
		 * that is used for displaying in the backbone template.
		 */
		$items_array = array();

		/**
		 * $meta_array will contain all of our items' settings 
		 * so that they can be edited with backbone.
		 */
		
		$meta_array = array();


		$meta_array[] = array( 'type' => 'custom', 'id' => 'selected', 'meta_key' => 'selected', 'current_value' => $selected, 'object_id' => $field_id );

		foreach ( $this->items[ $field_id ] as $item_id => $item ) {
			/**
			 * Add our item as a part of the return.
			 * This will allow us to delete it on the front-end later.
			 */
			$meta_array[] = array( 'type' => 'custom', 'id' => $item_id );

			$label = isset( $item[ 'label' ] ) ? $item[ 'label' ] : '';
			$value = isset( $item[ 'value' ] ) ? $item[ 'value' ] : '';
			$calc = isset( $item[ 'calc' ] ) ? $item[ 'calc' ] : '';
			$order = isset( $item[ 'order' ] ) ? $item[ 'order' ] : 999999;

			/**
			 * Add our item settings as individual settings for the purposes
			 * of backbone saving.
			 */

			// Label
			$meta_array[] = array( 'type' => 'custom', 'id' => 'item_' . $item_id . '_label' , 'object_id' => $item_id, 'meta_key' => 'label', 'current_value' => $label );
		
			// Value
			$meta_array[] = array( 'type' => 'custom', 'id' => 'item_' . $item_id . '_value' , 'object_id' => $item_id, 'meta_key' => 'value', 'current_value' => $value );

			// Calc
			$meta_array[] = array( 'type' => 'custom', 'id' => 'item_' . $item_id . '_calc' , 'object_id' => $item_id, 'meta_key' => 'calc', 'current_value' => $calc );
			
			// Order
			$meta_array[] = array( 'type' => 'custom', 'id' => 'item_' . $item_id . '_order' , 'object_id' => $item_id, 'meta_key' => 'order', 'current_value' => $order );
			
			// Add to our items array that will be used for display.
			$items_array[] = array( 'label' => $label, 'value' => $value, 'calc' => $calc, 'order' => $order, 'object_id' => $item_id );

		}

		$meta_array[] = array( 'type' => 'custom', 'id' => 'list_items', 'menu' => 'items', 'object_id' => $field_id, 'selected' => $selected, 'items' => $items_array );

		return $meta_array;
	}
}
