<?php

namespace App\Infrastructure\Model\User\Service\Language;

use App\Model\User\Service\Language\LanguageManager;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Request;
use Symfony\Component\Translation\Translator;

class LanguageManger implements LanguageManager
{
    const LANGUAGE_HEADER = 'Accept-Language';

    protected $lang = null;

    /**
     * @var array
     */
    private array $languages;
    private $default;
    /**
     * @var Translator
     */
    private Translator $translator;

    public function __construct(array $languages, $default, Translator $translator)
    {
        $this->languages = $languages;
        $this->default = $default;
        $this->lang = $default;
        $this->translator = $translator;
    }

    public function detect(ServerRequestInterface $request): string
    {
        $languages = explode(',', $request->getHeaderLine(self::LANGUAGE_HEADER));

        foreach ($languages as $language) {
            $name = explode(';', $language)[0];

            if(in_array($name, $this->languages)) {
                return $name;
            }
        }

        return $this->default;
    }

    public function available(string $lang): bool
    {
        return in_array($lang, $this->languages);
    }

    public function set(string $lang): void
    {
        $this->translator->setLocale($lang);
        $this->lang = $lang;
    }

    public function get(): string
    {
        return $this->lang;
    }
}
