<?php

function nf_admin_edit_form(){

	if ( isset ( $_REQUEST['form_id'] ) ) {
		$form_id = $_REQUEST['form_id'];
	} else {
		$form_id = '';
	}

	if ( $form_id != '' ) {
		$form_name = nf_get_form_setting( $form_id, 'name' );
	}

	?>

	<div id="icon-ninja-custom-forms" class="icon32"><br></div>
	<h2><?php _e( 'Form Editor', 'ninja-forms' );?> - <?php if ( isset ( $form_name ) ) echo $form_name;?> - ID : <?php echo $form_id;?></h2>

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
  		<?php
	  	$scope = 'form';
	  	$object_id = $form_id;
	  	$groups = Ninja_Forms()->admin_settings->get_settings_groups( $scope );

  		echo Ninja_Forms()->admin_settings_pages->get_sidebar_template( $scope, $groups, $object_id );
  		?>
		<div class="nf-settings-modal">
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

  </div>
  <?php
	echo Ninja_Forms()->admin_settings_pages->get_backbone_template( $scope, $groups, $object_id );
}

/**
 * Enqueue our JS for the edit form
 *
 * @since 3.0
 * @return void
 */

function nf_admin_edit_form_js() {
	wp_enqueue_script( 'nf-edit-form-backbone',
		NF_PLUGIN_URL .'js/dev/edit-form-backbone.js',
		array( 'nf-admin' ) );	
}