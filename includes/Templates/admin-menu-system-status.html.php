<div class="wrap">

    <div class="nf-box">
    	<div>
    		<h4><?php _e( 'Please include this information when requesting support:', 'ninja-forms' ); ?> </h4>
    		<p class="submit debug-report"><a href="#" class="button-primary"><?php _e( 'Get System Report', 'ninja-forms' ); ?></a></p>
    	</div>
    	<div id="debug-report"><textarea readonly="readonly"></textarea></div>
    </div>
    <br/>
    <table class="nf-status-table" cellspacing="0">
    	<thead>
    		<tr>
    			<th colspan="2"><?php _e( 'Environment', 'ninja-forms' ); ?></th>
    		</tr>
    	</thead>
    	<tbody>
            <?php foreach( $environment as $key => $value ): ?>
                <tr>
                    <td><?php echo $key . ':'; ?><td>
                    <td><?php echo $value; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

</div>
