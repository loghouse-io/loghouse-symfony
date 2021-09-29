<?php

namespace LoghouseIo\LoghouseSymfony;


use LoghouseIo\LoghouseSymfony\Factories\LoghouseSymfonyEntryFactory;
use LoghouseIo\LoghouseSymfony\Models\LoghouseSymfonyConfig;
use LoghouseIo\LoghouseSymfony\Models\LoghouseSymfonyEntriesStorage;
use LoghouseIo\LoghouseSymfony\Utils\LoghouseSymfonyHttpClient;

/**
 * Class LoghouseSymfony
 * @package LoghouseIo\LoghouseSymfony
 */
class LoghouseSymfony
{
    /**
     * @var LoghouseSymfonyConfig
     */
    private $config;

    /**
     * @var LoghouseSymfonyEntriesStorage
     */
    private $entriesStorage;

    /**
     * LoghouseSymfony constructor.
     * @param LoghouseSymfonyConfig $config
     * @param LoghouseSymfonyEntriesStorage $entriesStorage
     */
    public function __construct(
        LoghouseSymfonyConfig $config,
        LoghouseSymfonyEntriesStorage $entriesStorage
    ) {
        $this->config = $config;
        $this->entriesStorage = $entriesStorage;
    }

    /**
     * @param string $message
     * @param array $metadata
     */
    public function log(
        string $message,
        array $metadata = []
    ) {
        if (!$this->config->hasValidCredentials()) {
            return;
        }

        if (empty($message)) {
            return;
        }

        $entry = LoghouseSymfonyEntryFactory::create($this->config->getBucketId(), $message, $metadata);

        $this->entriesStorage->addEntry($entry);

        if ($this->config->isConsole()) {
            $this->send();
        }
    }

    public function send(): void
    {
        if (!$this->config->hasValidCredentials() || !$this->entriesStorage->hasEntries()) {
            return;
        }

        LoghouseSymfonyHttpClient::send(
            $this->config->getAccessToken(),
            $this->entriesStorage->serialize()
        );

        $this->entriesStorage->reset();
    }
}