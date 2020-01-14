<?php

namespace App\Model\Email\Entity\Event;

class MessageCreated
{
    public string $id;
    public string $host;
    public string $receiver;
    public string $sender;
    public string $subject;

    public function __construct($id, $host, $receiver, $sender, $subject)
    {
        $this->id = $id;
        $this->host = $host;
        $this->receiver = $receiver;
        $this->sender = $sender;
        $this->subject = $subject;
    }
}
