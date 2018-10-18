<?php

namespace Mail\Driver;

use Mail\Mail;
use Mail\Exception\Notify;
use Mailgun\Mailgun;

class MailGunDriver extends Mail
{
    public function send(): bool
    {
        $mgClient = new Mailgun($this->getKey());
        $mail = $this->compose();

        try {
            $mgClient->sendMessage($this->getDomain(), $mail,
                ['attachment' => $this->getAttachments()]);
            return true;
        } catch (Exception $e) {
            throw new Notify("MailGun Error: " . $e->getMessage());
        }
    }

    public function getDomains(array $options = []): object
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            // $options format ['limit' => 5, 'skip' => 10]
            return $mgClient->get('domains', $options);
        } catch (Exception $e) {
            throw new Notify("MailGun Error: " . $e->getMessage());
        }
    }
}