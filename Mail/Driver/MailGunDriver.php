<?php

namespace Mail\Driver;

use Mail\Mail;
use Mail\Exception\Notify;
use Mailgun\Mailgun;

use Mail\Traits\HelpfulMethodsTrait;

class MailGunDriver extends Mail
{
    use HelpfulMethodsTrait;

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

    public function getSingleDomain(): object
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->get('domains/' . $this->getDomain());
        } catch (Exception $e) {
            throw new Notify("MailGun Error: " . $e->getMessage());
        }
    }

    public function addDomain(): object
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->post('domains', [
                'name'          => $this->getDomain(),
                'smtp_password' => $this->generateRandomString()
            ]);
        } catch (Exception $e) {
            throw new Notify("MailGun Error: " . $e->getMessage());
        }
    }

    public function deleteDomain(): object
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->delete('domains/' . $this->getDomain());
        } catch (Exception $e) {
            throw new Notify("MailGun Error: " . $e->getMessage());
        }
    }

    public function getDomainEvents(array $options = []): object
    {
        $mgClient = new Mailgun($this->getKey());

        $queryString = [
            'begin'      => $options['begin'] ?? date('D, d F Y H:i:s -0000'),
            'ascending'  => $options['ascending'] ?? 'yes',
            'limit'      => $options['limit'] ?? 25,
            'pretty'     => $options['pretty'] ?? 'yes',
            'subject'    => $options['subject'] ?? 'test'
        ];

        try {
            return $mgClient->get($this->getDomain() . '/events', $queryString);
        } catch (Exception $e) {
            throw new Notify("MailGun Error: " . $e->getMessage());
        }
    }
}