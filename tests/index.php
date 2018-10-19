<?php

include "../vendor/autoload.php";

use Mail\Mail;

/**------ Testing the MailGun driver ------**/
$mail = Mail::getDriver('mailgun');

$mail->setKey('');
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
$mail->setDomain('staging.mycrystalhub.uk');
echo "<pre>";
print_r($mail->getDomainEvents());
echo "</pre>";

echo "Domains events should be retrieved";
echo "<br><hr><br>";