<div class="wrap">
    <?php foreach( $grouped_settings as $group => $settings ) : ?>
        <div id="ninja_forms_metabox_<?php echo $group; ?>_settings" class="postbox">
			<span class="item-controls">
				<a class="item-edit metabox-item-edit" id="edit_id" title="Edit Menu Item" href="#">Edit Menu Item</a>
			</span>
            <h3 class="hndle"><span><?php echo $group; ?></span></h3>
            <div class="inside" style="">
                <table class="form-table">
                    <tbody>
                        <?php foreach( $settings as $key => $setting ) : ?>

                            <?php if( 'prompt' == $setting[ 'type' ] ) continue; ?>

                            <tr id="row_<?php echo $setting[ 'id' ]; ?>">
                                <th scope="row">
                                    <label for="<?php echo $setting[ 'id' ]; ?>"><?php echo $setting[ 'label' ]; ?></label>
                                 </th>
                            <td>
                                <?php
                                    switch ( $setting[ 'type' ] ) {
                                        case 'desc' :
                                            echo $setting[ 'value' ];
                                            echo "<p class='description'>" . $setting[ 'desc' ] . "</p>";
                                            break;
                                        case 'textbox' :
                                            echo "<input type='text' class='code widefat' name='{$setting['id']}' id='{$setting['id']}' value='{$setting['value']}'>";
                                            echo "<p class='description'>" . $setting[ 'desc' ] . "</p>";
                                            break;
                                        case 'checkbox' :
                                            echo "<input type='hidden' name='{$setting['id']}' value='0'>";
                                            echo "<input type='checkbox' name='{$setting['id']}' value='1' id='{$setting['id']}' class='widefat'>";
                                            echo "<p class='description'>" . $setting[ 'desc' ] . "</p>";
                                    }
                                ?>
                            </td>
                            </tr>
                        </tbody>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div id="ninja_forms_metabox_general_settings" class="postbox">
			<span class="item-controls">
				<a class="item-edit metabox-item-edit" id="edit_id" title="Edit Menu Item" href="#">Edit Menu Item</a>
			</span>
    <h3 class="hndle"><span>General Settings</span></h3>
    <div class="inside" style="display: block;">
        <table class="form-table">
            <tbody>

            <tr id="row_version">
                <th scope="row">
                    <label for="version">Version</label>
                </th>
                <td>
                    2.9.33</td></tr>
            <tr id="row_date_format">
                <th scope="row">
                    <label for="date_format">Date Format</label>
                </th>
                <td>

                    <input type="text" class="code widefat" name="date_format" id="date_format" value="d/m/Y">
                    <p class="description">
                        e.g. m/d/Y, d/m/Y - Tries to follow the <a href="http://www.php.net/manual/en/function.date.php" target="_blank">PHP date() function</a> specifications, but not every format is supported.					</p>
                </td></tr>
            <tr id="row_currency_symbol">
                <th scope="row">
                    <label for="currency_symbol">Currency Symbol</label>
                </th>
                <td>

                    <input type="text" class="code widefat" name="currency_symbol" id="currency_symbol" value="$">
                    <p class="description">
                        e.g. $, £, €					</p>
                </td></tr>					</tbody>
        </table>
    </div>
</div>