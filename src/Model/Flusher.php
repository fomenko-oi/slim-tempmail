<?php

namespace App\Model;

interface Flusher
{
    public function flush(AggregateRoot ...$root): void;
}
