<?php
$I = new AcceptanceTester( $scenario );

// Login to wp-admin
$I->loginAsAdmin();

$I->wantTo( 'add field to existing form' );

// Make sure we're on our contact form.
$I->amOnPage( '/wp-admin/admin.php?page=ninja-forms&form_id=1' );

// Make sure we're on the fields domain.
$I->waitForText( 'Form Fields' );

// Add a new field
$I->click( 'a.nf-master-control' );
$I->waitForText( 'Single Checkbox' );
$I->click( '.nf-item[data-id="date"]' );

// Edit our field label
$I->waitForText( 'Single Checkbox' );
$I->click( '.nf-field-wrap:last-child' );
$I->waitForElement( '#label' );
$I->fillField( '#label', 'Agree?' );
$I->click( '.nf-close-drawer' );

// Preview the form and make sure that our label showed up.
$I->wait( 3 );
$I->click( 'a.preview' );
$I->wait( 5 );

$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});

$I->see( 'Agree?' );