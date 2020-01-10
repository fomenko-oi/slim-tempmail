<?php

namespace App\Http\Action\Main;

use App\Model\Domain\Entity\Domain;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestAction
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        //$em = $this->entityManager->getRepository(Domain::class);

        $em = 'asdf';
        dd($em);

        die;
    }
}
