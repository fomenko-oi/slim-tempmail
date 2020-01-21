<?php

namespace App\Model\Email\Entity;

use App\Model\AggregateRoot;
use App\Model\Email\Entity\Event\FileAttached;
use App\Model\Email\Entity\Event\MessageCreated;
use App\Model\EventTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="email_messages", indexes={@ORM\Index(name="mail_idx", columns={"host", "receiver"})})
 */
class EmailMessage implements AggregateRoot
{
    use EventTrait;

    /**
     * @ORM\Column(type="email_id")
     * @ORM\Id
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="native_id")
     */
    private $nativeId; // id got from IMAP
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $date; // format - 2020-01-13 18:21:46.000000
    /**
     * @ORM\Column(type="string")
     */
    private $host;
    /**
     * @ORM\Column(type="string")
     */
    private $receiver;
    /**
     * @ORM\Column(type="string")
     */
    private $sender;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $subject;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $type;
    /**
     * @ORM\Column(type="text")
     */
    private $body;
    /**
     * @ORM\Column(type="datetime_immutable", name="created_at")
     */
    private $createdAt;
    /**
     * @ORM\OneToMany(targetEntity="EmailFile", mappedBy="message", orphanRemoval=true, cascade={"persist"})
     */
    private $files;

    public function __construct(EmailId $id, EmailTo $to, EmailFrom $from, \DateTimeImmutable $date, $body, ?string $subject = null)
    {
        $this->id = $id;
        $this->receiver = $to->getAddress();
        $this->host = $to->getHost();
        $this->sender = $from->getAddress();
        $this->date = $date;
        $this->body = $body;
        $this->subject = $subject;
        $this->createdAt = new \DateTimeImmutable('now');

        $this->files = new ArrayCollection();
        $this->recordEvent(new MessageCreated($id, $to->getHost(), $to->getAddress(), $from->getAddress(), $subject));
    }

    /**
     * @return mixed
     */
    public function getId(): EmailId
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNativeId()
    {
        return $this->nativeId;
    }

    /**
     * @param mixed $nativeId
     */
    public function setNativeId($nativeId): self
    {
        $this->nativeId = $nativeId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host): self
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param mixed $to
     */
    public function setReceiver($to): self
    {
        $this->receiver = $to;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param mixed $from
     */
    public function setSender($from): self
    {
        $this->sender = $from;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject = null): self
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): self
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files->toArray();
    }

    public function addFile(EmailFile $file)
    {
        $file->setMessage($this);
        $this->files->add($file);
        $this->recordEvent(new FileAttached($file->getId(), $file->getPath(), $file->getName()));
    }

    public function hasAttachments(): bool
    {
        return $this->files->count() > 0;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
