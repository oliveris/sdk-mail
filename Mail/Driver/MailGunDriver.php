<?php

namespace Mail\Driver;

use Mail\Mail;
use Mail\Exception\Notify;
use Mailgun\Mailgun;

use Mail\Traits\HelpfulMethodsTrait;

class MailGunDriver extends Mail
{
    use HelpfulMethodsTrait;

    protected $mailing_list_name;

    protected $mailing_list_desc;

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
//            'pretty'     => $options['pretty'] ?? 'yes',
//            'subject'    => $options['subject'] ?? 'test'
        ];

        try {
            return $mgClient->get($this->getDomain() . '/events', $queryString);
        } catch (Exception $e) {
            throw new Notify("MailGun Error: " . $e->getMessage());
        }
    }

    public function getDomainEventsFailures(): object
    {
        $mgClient = new Mailgun($this->getKey());

        $queryString = ['event' => 'rejected OR failed'];

        try {
            return $mgClient->get($this->getDomain() . '/events', $queryString);
        } catch (Exceptions $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function getDomainStatsAll(): object
    {
        $mgClient = new Mailgun($this->getKey());

        $queryString = [
            'event'    => ['accepted', 'delivered', 'failed', 'opened', 'clicked', 'unsubscribed', 'complained', 'stored'],
            'duration' => '1m'
        ];

        try {
            return $mgClient->get($this->getDomain() . '/stats/total', $queryString);
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function getDomainStatsByEvents(array $events): object
    {
        $mgClient = new Mailgun($this->getKey());

        // $events = ['accepted', 'delivered', 'failed', 'opened', 'clicked', 'unsubscribed', 'complained', 'stored']
        $queryString = [
            'event'    => $events,
            'duration' => '1m'
        ];

        if (empty($events)) {
            throw new Notify("Mailgun SDK Error: No events passed");
        }

        try {
            return $mgClient->get($this->getDomain() . '/stats/total', $queryString);
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function getDomainTags(array $options = []): object
    {
        $mgClient = new Mailgun($this->getKey());

        $queryString = [
            'limit' => $options['limit'] ?? 10
        ];

        try {
            return $mgClient->get($this->getDomain() . '/tags', $queryString);
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function deleteDomainTag(string $tag = ''): object
    {
        $mgClient = new Mailgun($this->getKey());

        if (empty($tag)) {
            throw new Notify("Mailgun SDK Error: No tag has been set");
        }

        try {
            return $mgClient->delete($this->getDomain() . '/tags/' . $tag);
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function getDomainBounces(): object
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->get($this->getDomain() . '/bounces');
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function getDomainSingleBounce(string $address = ''): object
    {
        $mgClient = new Mailgun($this->getKey());

        if (empty($address)) {
            throw new Notify("Mailgun SDK Error: No address has been set");
        }

        try {
            return $mgClient->get($this->getDomain() . '/bounces/' . $address);
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function addDomainBounce(string $address = ''): object
    {
        $mgClient = new Mailgun($this->getKey());

        if (empty($address)) {
            throw new Notify("Mailgun SDK Error: No address has been set");
        }

        try {
            return $mgClient->post($this->getDomain() . '/bounces', ['address' => $address]);
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function deleteDomainBounce(string $address = ''): object
    {
        $mgClient = new Mailgun ($this->getKey());

        if (empty($address)) {
            throw new Notify("Mailgun SDK Error: No address has been set");
        }

        try {
            return $mgClient->delete($this->getDomain() . '/bounces/' . $address);
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function deleteDomainBounceList(): object
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->get($this->getDomain() . '/bounces');
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function setDomainMailingListName(string $value = ''): string
    {
        if (!empty($value)) {
            $this->mailing_list_name = $value;
            return $this->mailing_list_name;
        } else {
            throw new Notify("Mailgun SDK Error: Mailing list name has not been set");
        }
    }

    public function getDomainMailingListName(): string
    {
        if (isset($this->mailing_list_name)) {
            return $this->mailing_list_name;
        } else {
            throw new Notify("Mailgun SDK Error: The mailing list name has not been set");
        }
    }

    public function setDomainMailingListDescription(string $value = ''): string
    {
        if (!empty($value)) {
            $this->mailing_list_desc = $value;
            return $this->mailing_list_desc;
        } else {
            throw new Notify("Mailgun SDK Error: The mailing list description has not been set");
        }
    }

    public function addDomainMailingList(): object
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->post('lists', [
                'address' => $this->getDomainMailingListName() . '@' . $this->getDomain()
            ]);
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }
}