<?php

namespace App\Model\Email\Entity\Event;

class MessageUploaded
{
    public string $id;
    public string $host;
    public string $receiver;
    public string $sender;
    public string $subject;
    public bool $withAttachments;

    public function __construct($id, $host, $receiver, $sender, $subject, $withAttachments = false)
    {
        $this->id = $id;
        $this->host = $host;
        $this->receiver = $receiver;
        $this->sender = $sender;
        $this->subject = $subject;
        $this->withAttachments = $withAttachments;
    }
}
