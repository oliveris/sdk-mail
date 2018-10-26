# Mail SDK
## PHP-SDK for multiple Mail services

<p>Pupose of the SDK is to help with the delivery of mail and campaigns using multiple services.</p>

### Usage
<p>Pull in the composer package by running the command below:</p>

```
composer require oliveris/sdk-mail
```

<p>Import the Mail namespace into the class (autoloading)</p>

```
use Mail\Mail;
```

## Examples

### Sending an email
<p>The following example demonstrates how you can send a basic email</p>

```
$mail = Mail::getDriver('mailgun');
$mail->setKey('your_maligun_api_key');
$mail->setDomain('your_domain');
$mail->setTo('test@test.com');
$mail->setFrom('test-from@test.com');
$mail->setSubject('This is a test subject');
$mail->setBody('Lorem ipsum dolor sit amet, mollis hendrerit vix at. Altera meliore signiferumque vix an. Sonet delectus assentior eu sed, cu meliore ponderum quo. At quo idque virtute. Impedit mentitum est ei, assum abhorreant eam cu.');
$mail->send();
```

### Sending a batch email
<p>The following example demonstrates how you can send batch emails.</p>

```
$mail = Mail::getDriver('mailgun');
$mail->setKey('your_maligun_api_key');
$mail->setDomain('your_domain');
$mail->setTo([
    'test@test.com',
    'test2@test.com'
]);
$mail->setFrom('test-from@test.com');
$mail->setSubject('This is a test subject');
$mail->setBody('Lorem ipsum dolor sit amet, mollis hendrerit vix at. Altera meliore signiferumque vix an. Sonet delectus assentior eu sed, cu meliore ponderum quo. At quo idque virtute. Impedit mentitum est ei, assum abhorreant eam cu.');
$mail->send();
```

<p>For further examples look in the tests/index.php.</p>

## Built With
<ul>
    <li>PHP 7</li>
</ul>

## Versioning
<p>We use <a href="https://semver.org/spec/v1.0.0.html">Semantic Versioning 1.0.0</a>, for example v1.0.0.</p>

## Authors
<ul>
    <li>Sam Oliveri - Software Engineer</li>
</ul>

### License

Text is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).