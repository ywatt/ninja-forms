<?php
$I = new AcceptanceTester( $scenario );

$I->wantTo( 'make sure the date picker shows up properly' );
// Login to wp-admin
$I->loginAsAdmin();

$I->amOnPage( '/wp-admin/admin.php?page=ninja-forms&form_id=new' );

$I->waitForText( 'Date' );
$I->click( '[data-id="date"]' );
$I->wait(1);

$I->click( '[data-id="submit"]' );
$I->wait(1);

$I->click( 'a.nf-close-drawer' );
$I->click( 'Advanced' );
$I->click( 'div.display' );

$I->wait( 5 );

$I->waitForElement( '#title' );
$I->fillField( '#title', 'My New Form' );
$I->click( '.nf-close-drawer' );

$I->waitForText( 'PUBLISH' );
$I->click( 'PUBLISH' );
$I->wait( 3 );
$I->waitForText( 'PUBLISH' );
$I->click( 'PUBLISH' );

$I->wait( 5 );
$I->click( 'a.preview' );
$I->wait( 5 );

$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});

$I->fillField( '.pikaday__display', '01/12/2017' );
$I->wait( 2 );
$I->seeElement( '.pika-single' );