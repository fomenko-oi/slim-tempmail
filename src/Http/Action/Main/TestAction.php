<?php

namespace App\Http\Action\Main;

use App\Model\Domain\Entity\Domain;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\Route;
use Twig\Environment;

class TestAction
{
    /**
     * @var EntityManager
     */
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $em = $this->entityManager->getRepository(Domain::class);

        dd($em);

        die;
    }
}
