<?php
$I = new AcceptanceTester( $scenario );

$I->wantTo( 'check that the builder drawer opens and fields are added' );

// Login to wp-admin
$I->loginAsAdmin();

$I->amOnPage( '/wp-admin/admin.php?page=ninja-forms&form_id=new' );
$I->waitForText( 'Common Fields' );
$I->click( '.nf-field-type-button:first' );
$I->waitForElement('.nf-field-wrap', 30); 