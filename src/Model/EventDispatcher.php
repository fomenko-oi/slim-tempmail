<?php

namespace App\Model;

interface EventDispatcher
{
    public function dispatch(...$events): void;
}
