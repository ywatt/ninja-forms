<?php
$I = new AcceptanceTester( $scenario );

// Login to wp-admin
$I->loginAsAdmin();

$I->wantTo( 'confirm that form display loads properly' );
$I->amOnPage( '/?nf_preview_form=1' );
$I->waitForElementVisible( '.nf-before-form-content', 30 );
$I->waitForElementVisible( '.nf-form-content', 30 );
$I->waitForElementVisible( '.nf-after-form-content', 30 );