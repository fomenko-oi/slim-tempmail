<?php

namespace App\Http\Action\User\Cabinet;

use App\Model\User\Service\Language\LanguageManager;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class DetectLanguageAction
{
    /**
     * @var LanguageManager
     */
    private LanguageManager $languageManager;
    /**
     * @var Environment
     */
    private Environment $view;

    public function __construct(LanguageManager $languageManager, Environment $view)
    {
        $this->languageManager = $languageManager;
        $this->view = $view;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse(
            $this->view->render('app/users/locale.html.twig', [
                'lang' => $this->languageManager->get(),
                'message' => 'hello'
            ])
        );
    }
}
