<?php
$I = new AcceptanceTester( $scenario );

// Login to wp-admin
$I->loginAsAdmin();

$I->wantTo( 'edit form title' );
$I->amOnPage( '/wp-admin/admin.php?page=ninja-forms&form_id=1' );
$I->waitForText( 'Advanced' );
$I->click( 'Advanced' );

$I->waitForText( 'Display Settings' );
$I->click( 'div.display' );

$I->wait( 5 );

$I->waitForElement( '#title' );
$I->fillField( '#title', 'Swanky New Title' );
$I->click( '.nf-close-drawer' );

$I->waitForText( 'PUBLISH' );
$I->click( 'PUBLISH' );
$I->wait( 3 );
$I->waitForText( 'PUBLISH' );
$I->click( 'PUBLISH' );

$I->wait( 3 );
$I->click( 'a.preview' );
$I->wait( 5 );

$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
	$handles=$webdriver->getWindowHandles();
	$last_window = end($handles);
	$webdriver->switchTo()->window($last_window);
});

$I->see( 'Acceptance Testing Site' );
$I->see( 'Swanky New Title' );