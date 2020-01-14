<?php

namespace App\Service\Email;

class SenderService
{
    /**
     * @var \Swift_Mailer
     */
    private \Swift_Mailer $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send($to, $text, $attachment = null, ?string $subject = null)
    {
        $message = (new \Swift_Message())
            ->setFrom(getenv('MAILER_FROM_EMAIL'))
            ->setTo($to)
            ->setBody($text)
            ->setSubject($subject)
        ;

        if($attachment) {
            $message->attach(\Swift_Attachment::fromPath($attachment));
        }

        if (!$this->mailer->send($message)) {
            throw new \RuntimeException('Unable to send message.');
        }
    }
}
