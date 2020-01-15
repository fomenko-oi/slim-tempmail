<?php

namespace App\Model\Email\UseCase\Source;

use App\Model\Email\Entity\EmailMessage;
use App\Model\Email\Entity\MessageRepository;
use Ddeboer\Imap\ConnectionInterface;
use Ddeboer\Imap\Search\Email\To;
use Ddeboer\Imap\Search\RawExpression;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Server;

class Handler
{
    /**
     * @var ConnectionInterface
     */
    private ConnectionInterface $client;
    /**
     * @var MessageRepository
     */
    private MessageRepository $messages;

    public function __construct(ConnectionInterface $client, MessageRepository $messages)
    {
        $this->client = $client;
        $this->messages = $messages;
    }

    public function handle(Command $command): string
    {
        /** @var EmailMessage $message */
        $message = $this->messages->findById($command->id);

        $mailbox = $this->client->getMailbox('INBOX');

        $message = $mailbox->getMessage($message->getNativeId());

        return $message->getRawMessage();
    }
}


if(!function_exists('parseMailId'))
{
    function parseMailId($value)
    {
        $mailID = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
        $mailID = preg_replace('/[^0-9.]+/', '', $mailID);

        return $mailID;
    }
}
