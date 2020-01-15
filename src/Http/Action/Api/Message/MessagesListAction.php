<?php

namespace App\Http\Action\Api\Message;

use App\Infrastructure\Storage\UrlGenerator;
use App\Model\Email\Entity\EmailFile;
use App\Model\Email\Entity\EmailMessage;
use App\Model\Email\UseCase\Index\Command;
use App\Model\Email\UseCase\Index\Handler;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MessagesListAction
{
    /**
     * @var Handler
     */
    private Handler $handler;
    /**
     * @var UrlGenerator
     */
    private UrlGenerator $storageUrl;

    public function __construct(Handler $handler, UrlGenerator $storageUrl)
    {
        $this->handler = $handler;
        $this->storageUrl = $storageUrl;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $command = new Command();
        $command->email = $request->getAttribute('email');

        $messages = $this->handler->handle($command);

        return new JsonResponse([
            'count' => count($messages),
            'data' => array_map(fn(EmailMessage $message) => [
                'id'        => $message->getId()->getId(),
                'receiver'  => $message->getReceiver() . '@' . $message->getHost(),
                'date'      => $message->getDate()->format('d-m-Y G:i:s'),
                'native_id' => $message->getNativeId(),
                'type'      => $message->getType(),
                'subject'   => $message->getSubject(),
                'sender'    => $message->getSender(),
                'body'      => $message->getBody(),

                'attachments' => array_map(fn(EmailFile $file) => [
                    'id'        => $file->getId(),
                    'type'      => $file->getType(),
                    'name'      => $file->getName(),
                    'path'      => $this->storageUrl->url($file->getPath()),
                ], $message->getFiles())
            ], $messages)
        ], 200, [], JSON_PRETTY_PRINT);
    }
}
