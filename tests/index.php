<?php

include "../vendor/autoload.php";

use Mail\Mail;

/**------ Testing the MailGun driver ------**/
$mail = Mail::getDriver('mailgun');

$mail->setKey('key-9337ef899c7bc893f99849b222bac2bf');
$mail->setDomain('staging.mycrystalhub.uk');

// Test Sending
//$mail->setTo('sam.oliveri@usaycompare.com');
//$mail->setFrom('samoliveri92@gmail.com');
//$mail->setSubject('This is a test subject');
//$mail->setBody('Lorem ipsum dolor sit amet, mollis hendrerit vix at. Altera meliore signiferumque vix an. Sonet delectus assentior eu sed, cu meliore ponderum quo. At quo idque virtute. Impedit mentitum est ei, assum abhorreant eam cu.');
//$mail->send();
//
//echo "Mail should be sent";
//echo '<br><hr><br>';

// Test getting the domains
//echo "<pre>";
//print_r($mail->getDomains());
//echo "</pre>";
//
//echo "All domains set up on the mail gun account are listed here.";
//echo "<br><hr><br>";

// Test Getting a single domain
//echo "<pre>";
//print_r($mail->getSingleDomain());
//echo "</pre>";
//
//echo "Single domain should be retrieved";
//echo "<br><hr><br>";

// Test posting a domain
//$mail->setDomain('new.domain1.uk');
//echo "<pre>";
//print_r($mail->addDomain());
//echo "</pre>";
//
//echo "Single domain should be added";
//echo "<br><hr><br>";

// Test deleting a domain
//$mail->setDomain('new.domain1.uk');
//echo "<pre>";
//print_r($mail->deleteDomain());
//echo "</pre>";
//
//echo "Single domain should be deleted";
//echo "<br><hr><br>";

// Test getting a domains events
//$mail->setDomain('staging.mycrystalhub.uk');
//echo "<pre>";
//print_r($mail->getDomainEvents());
//echo "</pre>";
//
//echo "Domains events should be retrieved";
//echo "<br><hr><br>";

// Test getting domain with different types of failures
//echo "<pre>";
//print_r($mail->getDomainEventsFailures());
//echo "</pre>";
//
//echo "Domains events failures should be retrieved";
//echo "<br><hr><br>";

// Test getting the domains statistics
//echo "<pre>";
//print_r($mail->getDomainStats());
//echo "</pre>";
//
//echo "Domain stats should be retrieved";
//echo "<br><hr><br>";

// Test getting the domains stats by events
//echo "<pre>";
//print_r($mail->getDomainStatsByEvents(['failed']));
//echo "</pre>";
//
//echo "Domain stats should be retrieved";
//echo "<br><hr><br>";

// Test getting the domains stats
//echo "<pre>";
//print_r($mail->getDomainTags());
//echo "</pre>";
//
//echo "Domain tags should should be retrieved";
//echo "<br><hr><br>";

// Test getting the domain bounces
//echo "<pre>";
//print_r($mail->getDomainBounces());
//echo "</pre>";
//
//echo "Domain bounces should be retrieved";
//echo "<br><hr><br>";

// Test getting a single bounce#
//echo "<pre>";
//print_r($mail->getDomainSingleBounce('test2@test.com'));
//echo "</pre>";
//
//echo "Domain single bounce should be retrieved";
//echo "<br><hr><br>";

// Test adding a bounce
//echo "<pre>";
//print_r($mail->addDomainBounce('test2@test.com'));
//echo "</pre>";
//
//echo "Domain added to bounce list";
//echo "<br><hr><br>";

// Test deleting a bounce
//echo "<pre>";
//print_r($mail->deleteDomainBounce('test2@test.com'));
//echo "</pre>";
//
//echo "Domain bounce should be removed from the list";
//echo "<br><hr><br>";

// Test deleting an entire bounce list
//echo "<pre>";
//print_r($mail->deleteDomainBounceList());
//echo "</pre>";
//
//echo "Domain bounce list should be removed";
//echo "<br><hr><br>";

// Test creating a mailing list
//$mail->setDomainMailingListName('Testing List');
//$mail->setDomainMailingListDescription('This is a testing mailing list description');
//echo "<pre>";
//print_r($mail->addDomainMailingList());
//echo "</pre>";
//
//echo "The testing domains mailing list should be created";
//echo "<br><hr><br>";

// Testing a scheduled delivery
//$mail->setTo('sam.oliveri@usaycompare.com');
//$mail->setFrom('samoliveri92@gmail.com');
//$mail->setSubject('This is a test subject');
//$mail->setBody('Lorem ipsum dolor sit amet, mollis hendrerit vix at. Altera meliore signiferumque vix an. Sonet delectus assentior eu sed, cu meliore ponderum quo. At quo idque virtute. Impedit mentitum est ei, assum abhorreant eam cu.');
//$mail->setTags(['o:deliverytime' => date('D, d F Y 15:15:00 -0000')]);
//$mail->send();
//
//echo "Mail should be scheduled to send at 3:15pm";
//echo '<br><hr><br>';

// Test to get the domains unsubscribes
//$mail->setDomain('staging.mycrystalhub.uk');
//echo "<pre>";
//print_r($mail->getDomainUnsubscribes());
//echo "</pre>";
//
//echo "The domains unsubscribe list should be displayed below";
//echo "<br><hr><br>";

// Test to add an address to the unsubscribe list
//$mail->setDomain('staging.mycrystalhub.uk');
//echo "<pre>";
//print_r($mail->addDomainUnsubscribe('test-unsub@test.com'));
//echo "</pre>";
//
//echo "Address should be added to the domain unsubscribe list";
//echo "<br><hr><br>";

// Test to delete an address from the unsubscribe list
//$mail->setDomain('staging.mycrystalhub.uk');
//echo "<pre>";
//print_r($mail->deleteDomainUnsubscribe('test-unsub@test.com'));
//echo "</pre>";
//
//echo "Address should be removed from the domain unsubscribe list";
//echo "<br><hr><br>";

// Test to add a complaint to a domain
//$mail->setDomain('staging.mycrystalhub.uk');
//echo "<pre>";
//print_r($mail->addDomainSingleComplaint('test-addcomplaint@test.com'));
//echo "</pre>";
//
//echo "Address should be a complaint against the domain";
//echo "<br><hr><br>";

// Test to remove a complaint from a domain
$mail->setDomain('staging.mycrystalhub.uk');
echo "<pre>";
print_r($mail->deleteDomainSingleComplaint('test-addcomplaint@test.com'));
echo "</pre>";

echo "Address should be removed from the domain";
echo "<br><hr><br>";