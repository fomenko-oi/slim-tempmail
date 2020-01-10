<?php

namespace App\Service\Email;

use Ddeboer\Imap\Connection;
use Ddeboer\Imap\ConnectionInterface;
use Ddeboer\Imap\Server;

class MailService
{
    protected $client;
    /**
     * @var \Swift_Mailer
     */
    private \Swift_Mailer $mailer;

    public function __construct(ConnectionInterface $client, \Swift_Mailer $mailer)
    {
        $this->client = $client;
        $this->mailer = $mailer;
    }

    public function sendEmail($to, $text)
    {
        $message = (new \Swift_Message('Sign Up Confirmation'))
            ->setFrom(getenv('MAILER_FROM_EMAIL'))
            ->setTo($to)
            ->setBody($text)
        ;

        if (!$this->mailer->send($message)) {
            throw new \RuntimeException('Unable to send message.');
        }
    }

    public function getAllUnseenMessages()
    {
        $mailbox = $this->client->getMailbox('INBOX');

        $messages = $mailbox->getMessages();

        $data = [];
        foreach ($messages as $message) {
            dd($message->getTo());
        }

        return $data;
    }
}
