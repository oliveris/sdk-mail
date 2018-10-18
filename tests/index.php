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