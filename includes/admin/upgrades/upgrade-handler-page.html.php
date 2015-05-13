<div class="wrap">

    <h2>Upgrade Handler</h2>

    <?php foreach ( NF_UpgradeHandler()->upgrades as $upgrade ): ?>
        <div id="nf_upgrade_<?php echo $upgrade->name ?>">
            <dl class="menu-item-bar nf_upgrade">
                <dt class="menu-item-handle">
                    <span class="item-title ninja-forms-field-title nf_upgrade__name"><?php echo $upgrade->nice_name; ?></span>
                            <span class="item-controls">
                                <span class="item-type">
                                    <span class="item-type-name nf_upgrade__status">
                                        <!-- TODO: Move inline styles to Stylesheet. -->
                                        <!-- Status: INCOMPLETE -->
                                        <span class="dashicons dashicons-no" style="color: red; display: none;"></span>
                                        <!-- Status: PROCESSING -->
                                        <span class="spinner" style="display: none;margin-top: -1.5px;margin-right: -2px;"></span>
                                        <!-- Status: COMPLETE -->
                                        <span class="dashicons dashicons-yes" style="color: green; display: none;"></span>
                                    </span>
                                </span>
                            </span>
                </dt>
            </dl>
            <div class="menu-item-settings type-class inside" style="display: none;">
                <div id="progressbar_<?php echo $upgrade->name; ?>" class="progressbar">
                    <div class="progress-label">
                        Processing...
                    </div>
                </div>
                <p><?php echo $upgrade->description; ?></p>
                <div class="nf-upgrade-handler__errors" style="display: none; box-sizing: border-box; border: 1px solid #DEDEDE; padding-left: 5px; margin-right: 10px; border-radius: 3px; background-color: #EDEDED;">
                    <h3 class="nf-upgrade-handler__errors__title">
                        <!-- TODO: Translate Text -->
                        Error
                    </h3>
                    <pre class="nf-upgrade-handler__errors__text" style="padding-left: 10px;">

                    </pre>
                    <p>
                        <!-- TODO: Translate Text -->
                        Please <a href="https://ninjaforms.com/contact/">contact support</a>.
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</div> <!-- /.wrap -->
