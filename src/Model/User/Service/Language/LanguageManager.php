<?php

namespace App\Model\User\Service\Language;

use Psr\Http\Message\ServerRequestInterface;

interface LanguageManager
{
    public function detect(ServerRequestInterface $request): string;
    public function get(): string;
    public function set(string $lang): void;
    public function available(string $lang): bool;
}
