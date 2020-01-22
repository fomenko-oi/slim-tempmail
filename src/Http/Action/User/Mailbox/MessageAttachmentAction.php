<?php

namespace App\Http\Action\User\Mailbox;

use App\Model\Email\Entity\EmailFile;
use App\Model\Email\Entity\EmailMessage;
use App\Model\Email\Entity\FileRepository;
use App\Model\Email\Entity\MessageRepository;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Stream;

class MessageAttachmentAction
{
    /**
     * @var MessageRepository
     */
    private MessageRepository $messages;

    public function __construct(MessageRepository $messages)
    {
        $this->messages = $messages;
    }

    /**
     * @param ServerRequestInterface $request
     * @return \Psr\Http\Message\MessageInterface|ResponseInterface|\Slim\Psr7\Message
     */
    public function handle(ServerRequestInterface $request)
    {
        /** @var EmailMessage $message */
        $message = $this->messages->findById($request->getAttribute('message'));

        $fileId = $request->getAttribute('file');

        /** @var EmailFile $file */
        $file = array_filter($message->getFiles(), fn(EmailFile $file) => $file->getId() === $fileId)[0];

        $path = "storage/public/{$file->getPath()}";
        $fh = fopen($path, 'rb');
        $file_stream = new Stream($fh);

        return (new Response())
            ->withBody($file_stream)
            ->withHeader('Content-Disposition', "attachment; filename={$file->getName()};")
            ->withHeader('Content-Type', mime_content_type($path))
            ->withHeader('Content-Length', filesize($path));

    }
}
