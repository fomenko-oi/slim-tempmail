<?php

namespace App\Model\Domain\Entity;

use App\Model\Domain\Entity\Event\DomainCreated;
use App\Model\Domain\Entity\Event\DomainDisabled;
use App\Model\EventTrait;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="email_domains", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"host"})
 * })
 */
class Domain
{
    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';

    /**
     * @ORM\Column(type="domain_id")
     * @ORM\Id
     */
    private string $id;
    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $host;
    /**
     * @ORM\Column(type="datetime_immutable", name="checked_at", nullable=true)
     */
    private ?\DateTimeImmutable $checkedAt = null;
    /**
     * @ORM\Column(type="string", length=16)
     */
    private string $status;
    /**
     * @ORM\Column(type="domain_type", length=16)
     */
    private DomainType $type;

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
        $this->type = DomainType::common();

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

    public function getType(): ?DomainType
    {
        return $this->type;
    }
    public function setType(DomainType $type): self
    {
        $this->type = $type;
        return $this;
    }
}
