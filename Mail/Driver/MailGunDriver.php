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

    protected $mailing_list_member;

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

    public function getDomains(array $options = [])
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            // $options format ['limit' => 5, 'skip' => 10]
            return $mgClient->get('domains', $options);
        } catch (Exception $e) {
            throw new Notify("MailGun Error: " . $e->getMessage());
        }
    }

    public function getSingleDomain()
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->get('domains/' . $this->getDomain());
        } catch (Exception $e) {
            throw new Notify("MailGun Error: " . $e->getMessage());
        }
    }

    public function addDomain()
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

    public function deleteDomain()
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->delete('domains/' . $this->getDomain());
        } catch (Exception $e) {
            throw new Notify("MailGun Error: " . $e->getMessage());
        }
    }

    public function getDomainEvents(array $options = [])
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

    public function getDomainEventsFailures()
    {
        $mgClient = new Mailgun($this->getKey());

        $queryString = ['event' => 'rejected OR failed'];

        try {
            return $mgClient->get($this->getDomain() . '/events', $queryString);
        } catch (Exceptions $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function getDomainStatsAll()
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

    public function getDomainStatsByEvents(array $events)
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

    public function getDomainTags(array $options = [])
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

    public function deleteDomainTag(string $tag = '')
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

    /**----- Domain bounces -----**/

    public function getDomainBounces()
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->get($this->getDomain() . '/bounces');
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function getDomainSingleBounce(string $address = '')
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

    public function addDomainBounce(string $address = '')
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

    public function deleteDomainBounce(string $address = '')
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

    public function deleteDomainBounceList()
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->get($this->getDomain() . '/bounces');
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    /**----- Mailing lists -----**/

    public function setDomainMailingListName(string $value = ''): string
    {
        if (!empty($value)) {
            $this->mailing_list_name = str_replace(' ', '-', strtolower($value));
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

    public function getMailingListDescription(): string
    {
        if (isset($this->mailing_list_desc)) {
            return $this->mailing_list_desc;
        } else {
            throw new Notify("Mailgun SDK Error: The mailing list description needs to be set");
        }
    }

    public function addDomainMailingList()
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->post('lists', [
                'address'     => $this->getDomainMailingListName() . '@' . $this->getDomain(),
                'description' => $this->getMailingListDescription()
            ]);
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function deleteDomainMailingList()
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->delete('lists/' . $this->getDomainMailingListName() . '@' . $this->getDomain());
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function setMailingListMember(array $value = []): array
    {
        if (!array_key_exists('address', $value)) {
            throw new Notify("Mailgun SDK Error: The value \'address\' needs to be set");
        }

        if (!array_key_exists('name', $value)) {
            throw new Notify("Mailgun SDK Error: The value \'name\' needs to be set");
        }

        if (!array_key_exists('description', $value)) {
            throw new Notify("Mailgun SDK Error: The value \'description\' needs to be set");
        }

        if (!array_key_exists('subscribed', $value)) {
            throw new Notify("Mailgun SDK Error: The value \'subscribed\' needs to be set");
        }

        if (!array_key_exists('vars', $value)) {
            throw new Notify("Mailgun SDK Error: The value \'vars\' needs to be set");
        }

        return $this->mailing_list_member = $value;
    }

    public function getDomainMailingListMember(): array
    {
        if (isset($this->mailing_list_member)) {
            return $this->mailing_list_member;
        } else {
            throw new Notify("Mailgun SDK Error: The mailing list member needs to be set");
        }
    }

    public function addDomainMailingListMember()
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->post('lists/' . $this->getDomainMailingListName() . '/members',
                $this->getDomainMailingListMember());
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    /** Unsubscribes **/

    public function getDomainUnsubscribes()
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->get($this->getDomain() . '/unsubscribes', [
                'limit' => 5,
                'skip'  => 10
            ]);
        } catch (Exception $e) {
            throw new Notify("Mailgun error: " . $e->getMessage());
        }
    }

    public function getDomainSingleUnsubscribe(string $address = '')
    {
        $mgClient = new Mailgun($this->getKey());

        if (empty($address)) {
            throw new Notify("Mailgun SDK Error: No address has been set");
        }

        try {
            return $mgClient->get($this->getDomain() . '/unsubscribes/' . $address);
        } catch (Exception $e) {
            throw new Notify("Mailgun error: " . $e->getMessage());
        }
    }

    public function addDomainUnsubscribe(string $address = '')
    {
        $mgClient = new Mailgun($this->getKey());

        if (empty($address)) {
            throw new Notify("Mailgun SDK Error: No address has been set");
        }

        try {
            return $mgClient->post($this->getDomain() . '/unsubscribes', [
                'address' => $address,
                'tag'     => '*'
            ]);
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function deleteDomainUnsubscribe(string $address = '')
    {
        $mgClient = new Mailgun($this->getKey());

        if (empty($address)) {
            throw new Notify("Mailgun SDK Error: No address has been set");
        }

        try {
            return $mgClient->delete($this->getDomain() . '/unsubscribes/' . $address);
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    /** Complaints **/

    public function getDomainComplaints()
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->get($this->getDomain() . '/complaints', [
                'limit' => 10,
                'skip'  => 5
            ]);
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function getDomainSingleComplaint(string $address = '')
    {
        $mgClient = new Mailgun($this->getKey());

        if (empty($address)) {
            throw new Notify("Mailgun SDK Error: No address has been set");
        }

        try {
            return $mgClient->get($this->getDomain() . '/complaints/' . $address);
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function addDomainSingleComplaint(string $address = '')
    {
        $mgClient = new Mailgun($this->getKey());

        if (empty($address)) {
            throw new Notify("Mailgun SDK Error: No address has been set");
        }

        try {
            return $mgClient->post($this->getDomain() . '/complaints', [
                'address' => $address
            ]);
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function deleteDomainSingleComplaint(string $address = '')
    {
        $mgClient = new Mailgun($this->getKey());

        if (empty($address)) {
            throw new Notify("Mailgun SDK Error: No address has been set");
        }

        try {
            return $mgClient->delete($this->getDomain() . '/complaints/' . $address);
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    /** Webhooks **/

    public function getDomainWebhooks()
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->get('domains/' . $this->getDomain() . '/webhooks');
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }

    public function getDomainWebhooksByEvent(string $event)
    {
        $mgClient = new Mailgun($this->getKey());

        try {
            return $mgClient->get($this->getDomain() . '/webhooks/' . $event);
        } catch (Exception $e) {
            throw new Notify("Mailgun Error: " . $e->getMessage());
        }
    }
}