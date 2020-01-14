<?php

namespace App\Model\Email\Entity\Event;

use App\Model\Domain\Entity\DomainId;

class FileAttached
{
    public string $id;
    public string $path;
    public string $name;

    public function __construct($id, string $path, string $name)
    {
        $this->id = $id;
        $this->path = $path;
        $this->name = $name;
    }
}
