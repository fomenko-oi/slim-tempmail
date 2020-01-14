<?php

namespace App\Model\Email\Entity;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;
use App\Model\Email\Entity\EmailMessage;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="email_message_files")
 */
class EmailFile
{
    /**
     * Surrogate key
     * @ORM\Column(type="guid")
     * @ORM\Id
     */
    private $id;
    /**
     * @var EmailMessage
     * @ORM\ManyToOne(targetEntity="EmailMessage", inversedBy="files")
     * @ORM\JoinColumn(name="message_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $message;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $path;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $type;

    public function __construct(string $path, string $name, string $type)
    {
        Assert::notEmpty($path);

        $this->id = Uuid::uuid4()->toString();
        $this->path = $path;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return \App\Model\Email\Entity\EmailMessage
     */
    public function getMessage(): \App\Model\Email\Entity\EmailMessage
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    public function setMessage(EmailMessage $message): self
    {
        $this->message = $message;
        return $this;
    }
}
