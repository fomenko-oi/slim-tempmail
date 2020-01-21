<?php

namespace App\Infrastructure\Model\EventDispatcher\Listener\Message;

use App\Infrastructure\Amqp\AMQPHelper;
use App\Model\Email\Entity\Event\MessageUploaded;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class SocketNotificationListener
{
    private $connection;

    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
    }

    public function __invoke(MessageUploaded $event)
    {
        $connection = $this->connection;

        $channel = $this->connection->channel();

        AMQPHelper::initNotifications($channel);
        AMQPHelper::registerShutdown($connection, $channel);

        $data = [
            'type' => 'notification',
            'host' => $event->host,
            'receiver' => $event->receiver,
            'subject' => $event->subject,
            'message_id' => $event->id,
        ];

        $message = new AMQPMessage(
            json_encode($data),
            ['content_type' => 'text/plain']
        );

        $channel->basic_publish($message, AMQPHelper::EXCHANGE_NOTIFICATIONS);
    }
}
