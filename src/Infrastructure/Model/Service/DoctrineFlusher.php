<?php

namespace App\Infrastructure\Model\Service;

use App\Model\AggregateRoot;
use App\Model\EventDispatcher;
use App\Model\Flusher;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineFlusher implements Flusher
{
    private $em;
    private $dispatcher;

    public function __construct(EntityManagerInterface $em, EventDispatcher $dispatcher)
    {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
    }

    public function flush(AggregateRoot ...$roots): void
    {
        $this->em->flush();
        $events = array_reduce($roots, function (array $events, AggregateRoot $root) {
            return array_merge($events, $root->releaseEvents());
        }, []);
        $this->dispatcher->dispatch(...$events);
    }
}
