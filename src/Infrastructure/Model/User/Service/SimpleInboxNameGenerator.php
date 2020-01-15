<?php

namespace App\Infrastructure\Model\User\Service;

use App\Model\User\Service\InboxNameGenerator;

class SimpleInboxNameGenerator implements InboxNameGenerator
{
    public function generate($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $randomName = '';
        for($j=0; $j < $length; $j++){
            $randomName .= $characters[rand(0, strlen($characters) -1)];
        }

        return $randomName;
    }
}
