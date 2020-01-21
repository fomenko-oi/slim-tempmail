<?php

namespace App\Service\Email;

use App\Model\Email\Entity\EmailFile;
use App\Model\Email\Entity\EmailFrom;
use App\Model\Email\Entity\EmailId;
use App\Model\Email\Entity\EmailMessage;
use App\Model\Email\Entity\EmailTo;
use App\Model\Email\Entity\Event\MessageUploaded;
use App\Model\Email\Entity\MessageRepository;
use App\Model\Flusher;
use Ddeboer\Imap\ConnectionInterface;
use Ddeboer\Imap\Message\Attachment;
use Ddeboer\Imap\Message\EmbeddedMessage;
use Ddeboer\Imap\Search\Flag\Unseen;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\Filesystem;
use Ramsey\Uuid\Uuid;

class ReceiverService
{
    protected $client;
    /**
     * @var MessageRepository
     */
    private MessageRepository $messages;
    /**
     * @var Flusher
     */
    private Flusher $flusher;
    /**
     * @var Filesystem
     */
    private Filesystem $filesystem;

    public function __construct(ConnectionInterface $client, MessageRepository $messages, Flusher $flusher, Filesystem $filesystem)
    {
        $this->client = $client;
        $this->messages = $messages;
        $this->flusher = $flusher;
        $this->filesystem = $filesystem;
    }

    public function saveUnseenMessages(): int
    {
        $mailbox = $this->client->getMailbox('INBOX');
        $messages = $mailbox->getMessages(new Unseen());

        $count = 0;
        $events = [];
        foreach ($messages as $message) {
            $to = $message->getTo()[0];

            $data = new EmailMessage(
                EmailId::next(),
                new EmailTo($to->getAddress(), $to->getHostname()),
                new EmailFrom($message->getFrom()->getFullAddress()),
                $message->getDate(),
                $message->getBodyHtml() ?? $message->getBodyText(),
                $message->getSubject()
            );

            $data->setType($message->getType());
            $data->setNativeId($message->getNumber());

            $attachments = $message->getAttachments();

            /** @var Attachment $attachment */
            foreach ($attachments as $attachment) {
                if($attachment->isEmbeddedMessage()) {
                    /** @var EmbeddedMessage $embeddedMessage */
                    //$embeddedMessage = $attachment->getEmbeddedMessage();
                    continue;
                }

                $filePath = 'attachments/' . $this->generateName($attachment->getFilename());
                $this->filesystem->put($filePath, $attachment->getDecodedContent());

                $data->addFile($dataAttachment = new EmailFile($filePath, $attachment->getFilename(), $attachment->getType()));
            }

            $data->recordEvent(new MessageUploaded(
                $data->getId(),
                $data->getHost(),
                $data->getReceiver(),
                $data->getSender(),
                $data->getSubject(),
                $data->hasAttachments()
            ));

            $events[] = $data;
            $this->messages->add($data);

            $message->markAsSeen();
            $count++;
        }

        $this->flusher->flush(...$events);

        return $count;
    }

    protected function generateName($filename): string
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        return Uuid::uuid4()->toString() . '.' . $extension;
    }
}
