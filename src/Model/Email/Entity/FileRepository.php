<?php

namespace App\Model\Email\Entity;

interface FileRepository
{
    public function findById(string $id): ?EmailFile;
}
