<?php

/**
 * Output our all forms page.
 * 
 * @since 3.0
 * @return void
 */

function nf_admin_all_forms() {
	$all_forms = nf_get_all_forms();

	$form_count = count( $all_forms );

	if( isset( $_REQUEST['limit'] ) ){
		$saved_limit = absint( $_REQUEST['limit'] );
		$limit = absint( $_REQUEST['limit'] );
	}else{
		$saved_limit = 20;
		$limit = 20;
	}

	if( $form_count < $limit ){
		$limit = $form_count;
	}

	if( isset( $_REQUEST['paged']) AND !empty( $_REQUEST['paged'] ) ){
		$current_page = absint( $_REQUEST['paged'] );
	}else{
		$current_page = 1;
	}

	if( $form_count > $limit ){
		$page_count = ceil( $form_count / $limit );
	}else{
		$page_count = 1;
	}

	if( $current_page > 1 ){
		$start = ( ( $current_page - 1 ) * $limit );
		if( $form_count < $limit ){
			$end = $form_count;
		}else{
			$end = $current_page * $limit;
			$end = $end - 1;
		}

		if( $end > $form_count ){
			$end = $form_count;
		}
	}else{
		$start = 0;
		$end = $limit;
	}

	?>
	
	<div id="icon-ninja-custom-forms" class="icon32"><br></div>
	<h2><a href="#new_form" rel="modal:open"><input type="button" id="nf_new_form" class="open-settings-modal button button-primary" value="<?php _e( 'New Form', 'ninja-forms' );?>"></a></h2>

	<ul class="subsubsub">
		<li class="all"><a href="" class="current"><?php _e( 'All', 'ninja-forms' ); ?> <span class="count">(<?php echo $form_count;?>)</span></a>
	</ul>
	<div id="" class="tablenav top">
		<div class="alignleft actions">
			<select id="" class="" name="bulk_action">
				<option value=""><?php _e( 'Bulk Actions', 'ninja-forms' );?></option>
				<option value="delete"><?php _e( 'Delete', 'ninja-forms' );?></option>
				<!-- <option value="export"><?php _e( 'Export Forms', 'ninja-forms' );?></option> -->
			</select>
		</div>
		<div class="alignleft actions">
			<select id="nf_form_type" name="">
				<option value="">All Types</option>
				<option value="contact">Contact</option>
				<option value="support">Support</option>
				<option value="post_creation">Post Creation</option>
			</select>
			<span class="spinner"></span>
		</div>
		<div id="" class="alignright navtable-pages">
			<?php
			if($form_count != 0 AND $current_page <= $page_count){
			?>
			<span class="displaying-num"><?php if($start == 0){ echo 1; }else{ echo $start; }?> - <?php echo $end;?> <?php _e( 'of', 'ninja-forms' ); ?> <?php echo $form_count;?> <?php if($form_count == 1){ _e( 'Form', 'ninja-forms' ); }else{ _e( 'Forms', 'ninja-forms' ); }?></span>
			<?php
			}
				if($page_count > 1){

					$first_page = remove_query_arg('paged');
					$last_page = add_query_arg(array('paged' => $page_count));

					if($current_page > 1){
						$prev_page = $current_page - 1;
						$prev_page = add_query_arg(array('paged' => $prev_page));
					}else{
						$prev_page = $first_page;
					}
					if($current_page != $page_count){
						$next_page = $current_page + 1;
						$next_page = add_query_arg(array('paged' => $next_page));
					}else{
						$next_page = $last_page;
					}

			?>
			<span class="pagination-links">
				<a class="first-page disabled" title="<?php _e( 'Go to the first page', 'ninja-forms' ); ?>" href="<?php echo $first_page;?>">«</a>
				<a class="prev-page disabled" title="<?php _e( 'Go to the previous page', 'ninja-forms' ); ?>" href="<?php echo $prev_page;?>">‹</a>
				<span class="paging-input"><input class="current-page" title="Current page" type="text" name="paged" value="<?php echo $current_page;?>" size="2"> of <span class="total-pages"><?php echo $page_count;?></span></span>
				<a class="next-page" title="<?php _e( 'Go to the next page', 'ninja-forms' ); ?>" href="<?php echo $next_page;?>">›</a>
				<a class="last-page" title="<?php _e( 'Go to the last page', 'ninja-forms' ); ?>" href="<?php echo $last_page;?>">»</a>
			</span>
			<?php
				}
			?>
		</div>
	</div>
	<table class="wp-list-table widefat fixed posts">
		<thead>
			<tr>
				<th class="check-column"><input type="checkbox" id="" class="ninja-forms-select-all" title="ninja-forms-bulk-action"></th>
				<th><?php _e( 'Name', 'ninja-forms' );?></th>
				<th><?php _e( 'Type', 'ninja-forms' );?></th>		
				<th><?php _e( 'Statistics', 'ninja-forms' );?></th>
				<th><?php _e( 'Date Updated', 'ninja-forms' );?></th>
			</tr>
		</thead>
		<tbody id="nf-all-forms-content">

		</tbody>
		<tfoot>
			<tr>
				<th class="check-column"><input type="checkbox" id="" class="ninja-forms-select-all" title="ninja-forms-bulk-action"></th>
				<th><?php _e( 'Name', 'ninja-forms' );?></th>
				<th><?php _e( 'Type', 'ninja-forms' );?></th>				
				<th><?php _e( 'Statistics', 'ninja-forms' );?></th>
				<th><?php _e( 'Date Updated', 'ninja-forms' );?></th>
			</tr>
		</tfoot>
	</table>

  <div id="new_form" style="display:none;">
<!--   	<a class="media-modal-close" href="#close-modal" rel="modal:close" title="Close">
  		<span class="media-modal-icon"></span>
  	</a> -->
  	<div class="nf-new-form wp-core-ui media-frame" id="">
		<div class="wizard-header">
			<div alt="Close overlay" href="#close-modal" rel="modal:close" class="close dashicons dashicons-no"></div>
			<div>Test</div>
			<!--
			<div alt="Show previous" class="left dashicons dashicons-no disabled"></div>
			<div alt="Show next" class="right dashicons dashicons-no"></div>
			-->
		</div>
		<div id="new-form-creation">
			<div class="ninja-row">
				<div class="ninja-col-1-2 nf-wz-options">
					<div class="inside" id="wizard-left">
						
					</div>
				</div>
				<div class="ninja-col-1-2 nf-wz-instructions">
					<div class="inside" id="wizard-right">
						
					</div>
				</div>
			</div>
		</div>

	</div>
	<div class="wizard-actions" id="wizard-actions">
		&nbsp;
	</div>
  </div>

  <script type="text/html" id="tmpl-all-forms">
  	<%
  	if ( forms.length > 0 ) {
	  	_.each(forms, function(form){ %>
	  		
	  		<tr id="ninja_forms_form_<%= form.get( 'id' ) %>_tr">
				<th scope="row" class="check-column">
					<input type="checkbox" id="" name="form_ids[]" value="<%= form.get( 'id' ) %>" class="ninja-forms-bulk-action">
				</th>
				<td class="post-title page-title column-title">
					<strong>
						<a href="<%= form.get( 'edit_link' ) %>"><%= form.get( 'name' ) %></a>
					</strong>
					<div class="row-actions">
						<span class="edit"><a href="<%= form.get( 'edit_link' ) %>"><?php _e( 'Edit', 'ninja-forms' ); ?></a> | </span>
						<span class="trash"><a class="nf-delete-form" title="<?php _e( 'Delete this form', 'ninja-forms' ); ?>" href="#" data-form_id="<%= form.get( 'id' ) %>"><?php _e( 'Delete', 'ninja-forms' ); ?></a> | </span>
						<span class="export"><a href="<%= form.get( 'export_link' ) %>" title="<?php _e( 'Export Form', 'ninja-forms' ); ?>"><?php _e( 'Export', 'ninja-forms' ); ?></a> | </span>
						<span class="duplicate"><a href="<%= form.get( 'duplicate_link' ) %>" title="<?php _e( 'Duplicate Form', 'ninja-forms' ); ?>"><?php _e( 'Duplicate', 'ninja-forms' ); ?></a> | </span>
						<span class="bleep"><%= form.get( 'preview_link') %></span>
					</div>
				</td>
				<td>
					<%= form.get( 'type' ) %>
				</td>
				<td>
					<table>
						<thead>
							<tr>
								<th>
									Views
								</th>
								<th>
									Submissions
								</th>
								<th>
									Conversion
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<%= form.get( 'views' ) %>
								</td>
								<td>
									<a href="<%= form.get( 'subs_link' ) %>"><%= form.get( 'sub_count' ) %></a>
								</td>
								<td>
									<%= form.get( 'conversion' ) %>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td>
					<%= form.get( 'date_updated' ) %>
				</td>
			</tr>
	  	<%
		});

  	} else {
  		%>
  		<tr>
  			<td></td>
  			<td>
  				<?php _e( 'No forms found.', 'ninja-forms' ); ?>
  			</td>
  		</tr>
  		<%
  	}
  	%>
	</script>

	<?php
	$groups = Ninja_Forms()->admin_settings->get_settings_groups( 'form' );
	echo Ninja_Forms()->admin_settings_pages->get_backbone_template( 'form', $groups, 0 );

	?>

	<script type="text/html" id="tmpl-wizard-left-start">
		<p><input type="text" id="nf_new_form_name" class="widefat code" value="" placeholder="<?php _e( 'Form Name', 'ninja-forms' ); ?>"></p>
		<p class="wizard-section-actions"><a href="#" id="nf_create_form" class="button-secondary"><?php _e( 'Start Editing, Skip The Wizard', 'ninja-forms' );?></a>
			<a href="#" id="nf_new_form_wizard" class="button-primary"><?php _e( 'Creation Wizard, Please', 'ninja-forms' );?></a>
		</p>
		<span class='hidden'><?php wp_editor('hi','hi');?></span>
	</script>

	<script type="text/html" id="tmpl-wizard-right-start">
		<h3><?php _e( 'Create A New Form', 'ninja-forms' );?></h3>
		<div class="wizard-update-message">
			<p><strong><?php _e( 'To get started, enter a form name and then select whether or not you\'d like to use the form creation wizard.', 'ninja-forms' ); ?></strong></p>
		</div>
		<p class="wizard-description"><?php _e( 'The form creation wizard will assist you with all of the steps necessary to create a basic form. Once you have completed the wizard, you will be taken to the form editing page where you can make more changes to your form.', 'ninja-forms' ); ?></p>
	</script>

	<script type="text/html" id="tmpl-wizard-right">
		<h3><?php _e( 'Display Settings', 'ninja-forms' );?></h3>
		<div class="wizard-update-message">
			<p><strong><?php _e( 'First, we\'ll take a look at some display settings.', 'ninja-forms' ); ?></strong></p>
		</div>
		<p class="wizard-description"><?php _e( 'These settings will affect both how the form is shown and how it is submitted. The video below will explain these settings further.', 'ninja-forms' ); ?></p>
		<p class="wizard-description">
			<div class="videoWrapper">
				<iframe width="640" height="390" src="//www.youtube.com/embed/hVfPmKzqYpk" frameborder="0" allowfullscreen></iframe>
			</div>
		</p>
	</script>

	<script type="text/html" id="tmpl-wizard-actions-start">

	</script>

	<script type="text/html" id="tmpl-wizard-actions">
		<a class="button button-secondary" href="#" id="nf_wizard_previous">Previous</a>
		<a class="button button-primary" href="#" id="nf_wizard_next">Next</a>
	</script>

  	<?php

}

/**
 * Filter the get response of the REST API call for the all-forms list
 * 
 * @param array $args
 * @since 3.0
 * @return array $args
 */

function nf_all_forms_rest_filter( $args, $object_id, $group ) {
	// Bail if we aren't filtering the all_forms page.
	if ( $group != 'all_forms' )
		return $args;
	
	$forms = nf_get_all_forms();

	// Check to see if we are filtering by type
	if ( isset( $_REQUEST['type'] ) and $_REQUEST['type'] != '' ) {
		if ( is_array( $forms ) ) {
			$tmp_array = array();			
			foreach( $forms as $form ) { 
				$type = nf_get_form_setting( $form['id'], 'type' );
				if ( $type == $_REQUEST['type'] ) {
					$tmp_array[] = $form;
				}
			}
			$forms = $tmp_array;
		}
	}

	// Return an empty array if there are no forms
	if ( !is_array( $forms ) or empty( $forms ) )
		return $args;

	$all_forms = array();
	
	$x = 0;
	foreach( $forms as $form ) {
		$all_forms[$x]['id'] = $form['id'];
		$all_forms[$x]['name'] = nf_get_form_setting( $form['id'], 'name' );

		$date_updated = nf_get_form_setting( $form['id'], 'date_updated' );
		$date_updated = strtotime( $date_updated );
		$date_updated = date_i18n( __( 'F d, Y', 'ninja-forms' ), $date_updated );

		$all_forms[$x]['date_updated'] = $date_updated;
		$all_forms[$x]['edit_link'] = esc_url( add_query_arg( array( 'form_id' => $form['id'] ), admin_url( 'admin.php?page=ninja-forms-edit' ) ) );
		$all_forms[$x]['subs_link'] = admin_url( 'admin.php?page=ninja-forms-subs&form_id='.$form['id'] );
		$all_forms[$x]['export_link'] = esc_url( add_query_arg( array( 'export_form' => 1, 'form_id' => $form['id'] ), admin_url( 'admin.php?page=ninja-forms' ) ) );
		$all_forms[$x]['duplicate_link'] = esc_url( add_query_arg( array( 'duplicate_form' => 1, 'form_id' => $form['id'] ), admin_url( 'admin.php?page=ninja-forms' ) ) );
		$all_forms[$x]['preview_link'] = ninja_forms_preview_link( $form['id'] );

		$all_forms[$x]['type'] = nf_get_form_setting( $form['id'], 'type' );
		$all_forms[$x]['views'] = nf_get_form_setting( $form['id'], 'views' );
		$all_forms[$x]['sub_count'] = nf_get_form_setting( $form['id'], 'sub_count' );
		if ( $all_forms[$x]['sub_count'] > 0 and $all_forms[$x]['views'] > 0 ) {
			$conversion = $all_forms[$x]['sub_count'] / $all_forms[$x]['views'] * 100;
			$all_forms[$x]['conversion'] = intval( $conversion ) . '%';
		} else {
			$all_forms[$x]['conversion'] = '0%';
		}

		$x++;
	}

	return $all_forms;
}

/**
 * Filter the REST get request for the form creation wizard.
 * We're just going to return the form settings we want for the wizard.
 * 
 * @since 3.0
 * @return void
 */

function nf_wizard_rest_filter( $args, $object_id, $group ) {
	// Bail if we aren't filtering the creation wizard
	if ( $group != 'wizard' )
		return $args;

	// Set our wizard settings.
	if ( isset ( $_REQUEST['name'] ) and ! empty( $_REQUEST['name'] ) ) {
		for ($i=0; $i < count( $args ); $i++) { 
			if ( $args[$i]['id'] == 'name' ) {
				$args[$i]['current_value'] = $_REQUEST['name'];
			}
		}
	}

	return $args;
}

/**
 * Enqueue our JS for the all forms page
 * 
 * @since 3.0
 * @return void
 */

function nf_admin_all_forms_js() {
	wp_enqueue_script( 'nf-all-forms-backbone',
		NF_PLUGIN_URL .'js/dev/all-forms-backbone.js',
		array( 'nf-admin' ) );		
}