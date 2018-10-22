<?php

namespace Mail;

use Mail\Driver\MailGunDriver;
use Mail\Exception\Notify;

abstract class Mail
{
    protected $key;

    protected $domain;

    protected $from;

    protected $to;

    protected $cc;

    protected $bcc;

    protected $subject;

    protected $body;

    protected $html;

    protected $attachments;

    const DEFAULT_DRIVER = 'mailgun';

    const EMAIL_VALIDATION = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i';

    public static function getDriver(string $driver = self::DEFAULT_DRIVER): Mail
    {
        $driver = strtolower((string)$driver);
        switch ($driver) {
            case 'mailgun':
                return new MailGunDriver();
                break;
            default:
                throw new Notify("The mail driver {$driver} is not authorised");
        }
    }

    public function setKey(string $value): string
    {
        if (!empty($value)) {
            $this->key = $value;
            return $this->key;
        } else {
            throw new Notify("The key cannot be empty");
        }
    }

    public function getKey()
    {
        if (isset($this->key)) {
            return $this->key;
        } else {
            throw new Notify("The key needs to be set");
        }
    }

    public function setDomain(string $value = ''): string
    {
        if (!empty($value)) {
            $this->domain = $value;
            return $this->domain;
        } else {
            throw new Notify("The domain cannot be empty");
        }
    }

    public function getDomain()
    {
        if (isset($this->domain)) {
            return $this->domain;
        } else {
            throw new Notify("The domain has not been set");
        }
    }

    public function setFrom(string $value = ""): string
    {
        if (preg_match(self::EMAIL_VALIDATION, $value)) {
            $this->from = $value;
            return $this->from;
        } else {
            throw new Notify("The from email {$value} is not valid");
        }
    }

    public function setTo(string $value = ""): string
    {
        if (preg_match(self::EMAIL_VALIDATION, $value)) {
            $this->to = $value;
            return $this->to;
        } else {
            throw new Notify("The to email {$value} is not a valid email");
        }
    }

    public function setToBatch(array $value = []): array
    {
        if (!empty($value)) {
            $this->to = $value;
            return $this->to;
        } else {
            throw new Notify("The to value cannot be empty");
        }
    }

    public function setCc(string $value = ""): string
    {
        if (preg_match(self::EMAIL_VALIDATION, $value)) {
            $this->cc = $value;
            return $this->cc;
        } else {
            throw new Notify("The cc email {$value} is not a valid email");
        }
    }

    public function setBcc(string $value = ""): string
    {
        if (preg_match(self::EMAIL_VALIDATION, $value)) {
            $this->bcc = $value;
            return $this->bcc;
        } else {
            throw new Notify("The bcc email {$value} is not a valid email");
        }
    }

    public function setSubject(string $value = ""): string
    {
        if (!empty($value)) {
            $this->subject = $value;
            return $this->subject;
        } else {
            throw new Notify("The subject cannot be empty");
        }
    }

    public function setBody(string $value = ""): string
    {
        if (!empty($value)) {
            $this->body = nl2br($value);
            return $this->body;
        } else {
            throw new Notify("The body cannot be empty");
        }
    }

    public function setHtml(string $value = ""): string
    {
        if (!empty($value)) {
            $this->html = $value;
            return $this->html;
        } else {
            throw new Notify("The html cannot be empty");
        }
    }

    public function setAttachments(array $value = []): array
    {
        if (!empty($value)) {
            $this->attachments = $value;
            return $this->attachments;
        } else {
            throw new Notify("The attachments cannot be set to empty");
        }
    }

    public function getAttachments(): array
    {
        return !empty($this->attachments) ? $this->attachments : [];
    }

    public function compose(): array
    {
        if (isset($this->from, $this->to, $this->subject, $this->body)) {
            $mail = [];

            if (isset($this->from)) $mail['from'] = $this->from;
            if (isset($this->to)) $mail['to'] = $this->to;
            if (isset($this->cc)) $mail['cc'] = $this->cc;
            if (isset($this->bcc)) $mail['bcc'] = $this->bcc;
            if (isset($this->subject)) $mail['subject'] = $this->subject;
            if (isset($this->body)) $mail['text'] = $this->body;
            if (isset($this->html)) $mail['html'] = $this->html;

            return $mail;
        } else {
            throw new Notify("To send an Email to, subject, body and from must be set");
        }
    }

    abstract public function send(): bool;
}