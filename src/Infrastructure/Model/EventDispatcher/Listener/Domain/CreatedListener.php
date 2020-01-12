<?php

namespace App\Infrastructure\Model\EventDispatcher\Listener\Domain;

use App\Model\Domain\Entity\Event\DomainCreated;

class CreatedListener
{
    private $mailer;
    private $from;
    /**
     * @var string
     */
    private string $to;

    public function __construct(\Swift_Mailer $mailer, array $from, string $to)
    {
        $this->mailer = $mailer;
        $this->from = $from;
        $this->to = $to;
    }

    public function __invoke(DomainCreated $event)
    {
        $message = (new \Swift_Message('Custom user domain created'))
            ->setFrom($this->from)
            ->setTo($this->to)
            ->setBody("Domain {$event->domain} was created.")
        ;
        if (!$this->mailer->send($message)) {
            throw new \RuntimeException('Unable to send message.');
        }
    }
}
