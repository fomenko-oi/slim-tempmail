<?php

namespace App\Infrastructure\Model\Message\Entity;

use App\Model\Email\Entity\EmailMessage;
use App\Model\Email\Entity\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineMessageRepository implements MessageRepository
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
        $this->repo = $em->getRepository(EmailMessage::class);
        $this->em = $em;
    }

    public function findByHost(string $host)
    {
        return $this->repo->createQueryBuilder('m')
            ->andWhere('m.host = :host')
            ->setParameter(':host', $host)
            ->orderBy('v.createdAt', 'desc')
            ->getQuery()->getResult();
    }

    public function findById(string $id): ?EmailMessage
    {
        return $this->repo->createQueryBuilder('m')
            ->andWhere('m.id = :id')
            ->setParameter(':id', $id)
            ->setMaxResults(1)
            ->getQuery()->getSingleResult();
    }

    public function findByAddress(string $host, string $login)
    {
        return $this->repo->createQueryBuilder('m')
            ->andWhere('m.host = :host')
            ->andWhere('m.receiver = :login')
            ->setParameter(':host', $host)
            ->setParameter(':login', $login)
            ->orderBy('m.createdAt', 'asc')
            ->getQuery()->getResult();
    }

    public function add(EmailMessage $message): void
    {
        $this->em->persist($message);
    }
}
