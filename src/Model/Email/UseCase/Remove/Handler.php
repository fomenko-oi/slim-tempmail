<?php

namespace App\Model\Email\UseCase\Remove;

use App\Model\Email\Entity\EmailMessage;
use App\Model\Email\Entity\MessageRepository;
use App\Model\Flusher;
use Ddeboer\Imap\ConnectionInterface;
use Doctrine\ORM\EntityManagerInterface;

class Handler
{
    /**
     * @var ConnectionInterface
     */
    private ConnectionInterface $client;
    /**
     * @var MessageRepository
     */
    private MessageRepository $messageRepository;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;
    /**
     * @var Flusher
     */
    private Flusher $flusher;

    public function __construct(ConnectionInterface $client, MessageRepository $messageRepository, EntityManagerInterface $em, Flusher $flusher)
    {
        $this->client = $client;
        $this->messageRepository = $messageRepository;
        $this->em = $em;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        /** @var EmailMessage $message */
        $message = $this->messageRepository->findById($command->messageId);
        if(!$message) {
            throw new \InvalidArgumentException("Unable to find message with id {$command->messageId}.");
        }

        list($receiver, $host) = explode('@', $command->inbox);

        if($message->getHost() !== $host || $message->getReceiver() !== $receiver) {
            throw new \InvalidArgumentException('Unable to handle the message.');
        }

        // remove the image from mail server
        //$mailbox = $this->client->getMailbox('INBOX');
        //$mailbox->getMessage($message->getNativeId())->delete();

        $this->em->remove($message);
        $this->flusher->flush();
    }
}
