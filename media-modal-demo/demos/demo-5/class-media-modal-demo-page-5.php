<?php
/**
 * Demo Page Five
 */
class Media_Modal_Demo_Page_5 extends Media_Modal_Demo_Page_Abstract {
	/**
	 * Initialises the WP actions.
	 *  - print_media_templates
	 */
	public function init_hooks() {
		add_action( 'print_media_templates', array( $this, 'print_media_templates' ) );
	}

	/**
	 * Adds a new template for the HelloWorld view.
	 */
	public static function print_media_templates() {
		?>
		<script type="text/html" id="tmpl-basic-settings">
			<br />
			<div>
				<label>
					Label: 
					<input type="textbox" name="" value="Test">
				</label>
			</div>				
			<div>
				<label>
					Label Position: 
					<select id="" name="" class="">
						<option value="left">Left of Element</option>
						<option value="above">Above Element</option>
						<option value="below">Below Element</option>
						<option value="right">Right of Element</option>
						<option value="inside">Inside Element</option>
					</select>
				</label>
			</div>	
			<div>
				<label>
					Default Value: 
					<input type="textbox" name="" value="Test">
				</label>
			</div>
		</script>		

		<script type="text/html" id="tmpl-email-settings">
			<br />
			<div>
				<label>
					<input type="checkbox" name="" value="1">
					Use this as the <strong>from address</strong> for administrator emails.
				</label>
			</div>			
			<div>
				<label>
					<input type="checkbox" name="" value="1">
					Use this as the <strong>from name</strong> for administrator emails.
				</label>
			</div>
		</script>		

		<script type="text/html" id="tmpl-conditional-settings">
			<br />
			<div id="ninja-forms-conditionals">
				<span class="label">
					Conditional Statements - <a href="#" name="" id="ninja_forms_field_49_add_conditional" class="ninja-forms-field-add-conditional">Add Conditional Statement</a>
				</span>
				<input type="hidden" name="ninja_forms_field_49[conditional]" value="">
				<div id="ninja_forms_field_49_conditionals" class="" name="">
					<div id="ninja_forms_field_49_conditional_0" class="ninja-forms-field-49-conditional ninja-forms-condition" name="49">
						<div class="ninja-forms-condition-title">
							<a href="#" id="ninja_forms_field_49_remove_conditional" name="0" class="ninja-forms-field-remove-conditional" title="Remove condition">X</a>
							<select id="ninja_forms_field_49_conditional_0_action" name="ninja_forms_field_49[conditional][0][action]" class="ninja-forms-field-conditional-action">
								<option value="">-- Action</option>
								<option value="show">Show This</option>
								<option value="hide">Hide This</option>
								<option value="change_value">Change Value</option>
							</select>
							<span id="ninja_forms_field_49_0_value_span">
								<input type="hidden" name="ninja_forms_field_49[conditional][0][value]" value="">
							</span>
							If	<select name="ninja_forms_field_49[conditional][0][connector]">
								<option value="and">All</option>
								<option value="or">Any</option>
							</select>
							of the following critera are met: <a href="#" id="ninja_forms_field_49_add_cr" name="0" class="ninja-forms-field-add-cr">Add Criteria</a>
						</div>
						<div id="ninja_forms_field_49_conditional_0_cr" class="ninja-forms-criteria">
							<div class="description-wide single-criteria ninja-forms-field-49-conditional-0-cr" id="ninja_forms_field_49_conditional_0_cr_0">&nbsp;&nbsp; <a href="#" id="ninja_forms_field_49_remove_cr" class="ninja-forms-field-remove-cr" name="0" rel="0" title="Remove criteria">X</a> →
								<select name="ninja_forms_field_49[conditional][0][cr][0][field]" class="ninja-forms-field-conditional-cr-field" id="ninja_forms_field_49_cr_field" title="0_0">
									<option value="">-- Field</option>
									<option value="53">ID: 53 - Last Name</option>
									<option value="62">ID: 62 - Email Address</option>
									<option value="1016">ID: 1016 - File Upload</option>
								</select>
								<select name="ninja_forms_field_49[conditional][0][cr][0][operator]">
									<option value="==">=</option>
									<option value="!=">!=</option>
									<option value="&lt;">&lt;</option>
									<option value="&gt;">&gt;</option>
								</select>
								<br>
								<span id="ninja_forms_field_49_conditional_0_cr_0_value" class="">
									<input type="text" name="ninja_forms_field_49[conditional][0][cr][0][value]" id="ninja_forms_field_49_conditional_0_cr_0_value" class="" value="">
								</span>
							</div>
							<div class="description-wide single-criteria ninja-forms-field-49-conditional-0-cr" id="ninja_forms_field_49_conditional_0_cr_1">&nbsp;&nbsp; <a href="#" id="ninja_forms_field_49_remove_cr" class="ninja-forms-field-remove-cr" name="0" rel="1" title="Remove criteria">X</a> →
								<select name="ninja_forms_field_49[conditional][0][cr][1][field]" class="ninja-forms-field-conditional-cr-field" id="ninja_forms_field_49_cr_field" title="0_1">
									<option value="">-- Field</option>
									<option value="53">ID: 53 - Last Name</option>
									<option value="62">ID: 62 - Email Address</option>
									<option value="1016">ID: 1016 - File Upload</option>
								</select>
								<select name="ninja_forms_field_49[conditional][0][cr][1][operator]">
									<option value="==">=</option>
									<option value="!=">!=</option>
									<option value="&lt;">&lt;</option>
									<option value="&gt;">&gt;</option>
								</select>
								<br>
								<span id="ninja_forms_field_49_conditional_0_cr_1_value" class="">
									<input type="text" name="ninja_forms_field_49[conditional][0][cr][1][value]" id="ninja_forms_field_49_conditional_0_cr_1_value" class="" value="">
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</script>
		<?php
	}

	/**
	 * Enqueues the media script.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script(
			'media-modal-demo',
			plugins_url( 'js/media-modal-demo.js', __FILE__ ),
			array( 'media-views' )
		);
	}

	/**
	 * Prints a short description of what the demo does.
	 */
	public function print_description() {
		?>
		<p>Hello</p>
		<?php
	}

	/**
	 * Renders the demo page content.
	 */
	public function render_content() {
		?>
		<p>
			<input type="button" class="button open-media-button" id="open-media-modal" value="Edit Field Settings" />
		</p>
		<?php
	}
}
