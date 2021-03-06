<?php
namespace Upswarm\FunctionalTest\Fixtures;

use Exception;
use React\EventLoop\LoopInterface;
use Upswarm\Message;
use Upswarm\Service;

/**
 * Fixture to test exchangement of messages between services.
 */
class PongService extends Service
{
    /**
     * Provide the given service. This is the initialization point of the
     * service, the initialization point of the service.
     *
     * @param  LoopInterface $loop ReactPHP loop.
     *
     * @return void
     */
    public function serve(LoopInterface $loop)
    {
    }

    /**
     * Handles the messages that are received by this service.
     *
     * @param  Message       $message Incoming message.
     * @param  LoopInterface $loop    ReactPHP loop.
     *
     * @throws Exception In case of unknow message.
     *
     * @return void
     */
    public function handleMessage(Message $message, LoopInterface $loop)
    {
        switch ($message->getDataType()) {
            case 'integer':
                $number = $message->getData();
                echo "Pong received $number\n";
                $this->sendNumberToPing($number);

                break;

            default:
                throw new Exception("Unknow message '$message->getDataType'", 1);
                break;
        }
    }

    /**
     * Send the given number to PongService
     *
     * @param  integer $number Number to be sent.
     *
     * @return void
     */
    public function sendNumberToPing(int $number)
    {
        $this->sendMessage(new Message($number, PingService::class));
        echo "Pong sent $number\n";
    }
}
