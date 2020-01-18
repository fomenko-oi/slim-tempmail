<?php

namespace App\Infrastructure\Twig\Extension;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Contracts\Translation\TranslatorTrait;
use Twig\Extension\AbstractExtension;
use Twig\NodeVisitor\NodeVisitorInterface;
use Twig\TwigFilter;

final class TranslationExtension extends AbstractExtension
{
    private $translator;
    private $translationNodeVisitor;

    public function __construct(TranslatorInterface $translator = null, NodeVisitorInterface $translationNodeVisitor = null)
    {
        $this->translator = $translator;
        $this->translationNodeVisitor = $translationNodeVisitor;
    }
    public function getTranslator(): TranslatorInterface
    {
        if (null === $this->translator) {
            if (!interface_exists(TranslatorInterface::class)) {
                throw new \LogicException(sprintf('You cannot use the "%s" if the Translation Contracts are not available. Try running "composer require symfony/translation".', __CLASS__));
            }
            $this->translator = new class() implements TranslatorInterface {
                use TranslatorTrait;
            };
        }
        return $this->translator;
    }
    /**
     * {@inheritdoc}
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('trans', [$this, 'trans']),
        ];
    }
    public function trans(string $message, array $arguments = [], string $domain = null, string $locale = null, int $count = null): string
    {
        if (null !== $count) {
            $arguments['%count%'] = $count;
        }
        return $this->getTranslator()->trans($message, $arguments, $domain, $locale);
    }
}
