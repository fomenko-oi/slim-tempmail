<?php

namespace App\Infrastructure\Model\Domain\Entity;

use App\Model\Domain\Entity\Domain;
use App\Model\Domain\Entity\DomainRepository;
use App\Model\Domain\Entity\DomainType;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineDomainRepository implements DomainRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Domain::class);
        $this->em = $em;
    }

    public function all()
    {
        return $this->repo->findBy(['type' => DomainType::TYPE_COMMON, 'status' => Domain::STATUS_ENABLED]);
    }

    public function existsByHost(string $host): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.host = :host')
                ->setParameter(':host', $host)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function add(Domain $domain): void
    {
        $this->em->persist($domain);
    }

    public function random(): Domain
    {
        return $this->repo->createQueryBuilder('t')
            ->orderBy('RAND()')
            ->setMaxResults(1)
            ->getQuery()->getSingleResult();
    }
}
