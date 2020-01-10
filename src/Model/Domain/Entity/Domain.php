<?php

namespace App\Model\Domain\Entity;

use App\Model\Domain\Entity\Event\DomainCreated;
use App\Model\Domain\Entity\Event\DomainDisabled;
use App\Model\EventTrait;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="email_domains", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"host"})
 * })
 */
class Domain
{
    private const STATUS_ENABLED = 'enabled';
    private const STATUS_DISABLED = 'disabled';

    /**
     * @ORM\Column(type="domain_id")
     * @ORM\Id
     */
    private string $id;
    /**
     * @ORN\Column(type="string")
     */
    private string $host;
    /**
     * @ORM\Column(type="datetime_immutable", name="chacked_at")
     */
    private \DateTimeImmutable $checkedAt;
    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private string $status;

    use EventTrait;

    public function __construct(DomainId $id, string $domain)
    {
        Assert::notEmpty($domain);
        if (!filter_var($domain, FILTER_VALIDATE_DOMAIN)) {
            throw new \InvalidArgumentException('Incorrect domain.');
        }
        $this->id = $id;
        $this->host = mb_strtolower($domain);
        $this->status = self::STATUS_ENABLED;

        $this->recordEvent(new DomainCreated($id, $domain));
    }

    public function disable()
    {
        if($this->isDisabled()) {
            throw new \DomainException('The domain is already disabled.');
        }
        $this->status = self::STATUS_DISABLED;
        $this->recordEvent(new DomainDisabled($this->id, $this->host));
    }

    public function isEnabled(): bool
    {
        return $this->status === self::STATUS_ENABLED;
    }
    public function isDisabled(): bool
    {
        return $this->status === self::STATUS_DISABLED;
    }

    public function getId(): DomainId
    {
        return $this->id;
    }

    public function getHost(): string
    {
        return $this->host;
    }
    public function setHost(string $host): self
    {
        $this->host = $host;
        return $this;
    }

    public function getCheckedAt(): ?\DateTimeImmutable
    {
        return $this->checkedAt;
    }

    public function setCheckedAt(\DateTimeImmutable $checkedAt): self
    {
        $this->checkedAt = $checkedAt;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }
}
