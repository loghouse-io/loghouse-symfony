<?php

namespace LoghouseIo\LoghouseSymfony\Handlers;


use LoghouseIo\LoghouseSymfony\LoghouseSymfony;
use Monolog\Handler\AbstractProcessingHandler;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class LoghouseSymfonyHandler
 * @package LoghouseIo\LoghouseSymfony\Handlers
 */
class LoghouseSymfonyHandler extends AbstractProcessingHandler
{
    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var string
     */
    private $bucketId;

    /**
     * @var LoghouseSymfony
     */
    private $loghouseSymfony;

    /**
     * LoghouseSymfonyHandler constructor.
     * @param EventDispatcherInterface $eventDispatcher
     * @param string $accessToken
     * @param string $bucketId
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, string $accessToken, string $bucketId)
    {
        $this->accessToken = $accessToken;
        $this->bucketId = $bucketId;

        $this->loghouseSymfony = new LoghouseSymfony($this->accessToken, $this->bucketId);

        if ($eventDispatcher) {
            $eventDispatcher->addListener(KernelEvents::TERMINATE, function () {
                $this->loghouseSymfony->send();
            });
        }
    }

    protected function write(array $record): void
    {
        $this->loghouseSymfony->log($record['message'], [
            'level' => $record['level'],
            'level_name' => $record['level_name']
        ]);
    }
}