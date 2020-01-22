<?php

namespace App\Infrastructure\Model\Message\Entity;

use App\Model\Email\Entity\EmailFile;
use App\Model\Email\Entity\FileRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineFileRepository implements FileRepository
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
        $this->repo = $em->getRepository(EmailFile::class);
        $this->em = $em;
    }

    public function findById(string $id): ?EmailFile
    {
        // TODO fix this (doesn't work)
        return $this->repo->createQueryBuilder('f')
            ->andWhere('f.id = :id')
            ->setParameter(':id', $id)
            ->setMaxResults(1)
            ->getQuery()->getSingleResult();
    }
}
