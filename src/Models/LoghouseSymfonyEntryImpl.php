<?php

namespace LoghouseIo\LoghouseSymfony\Models;

/**
 * Class LoghouseSymfonyEntryImpl
 * @package LoghouseIo\LoghouseSymfony\Models
 */
class LoghouseSymfonyEntryImpl implements LoghouseSymfonyEntry
{
    /**
     * @var string
     */
    private $bucketId;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $timestamp;

    /**
     * @var array
     */
    private $metadata;

    /**
     * LoghouseSymfonyEntryImpl constructor.
     * @param string $message
     * @param string $timestamp
     * @param array $metadata
     */
    public function __construct(
        string $bucketId,
        string $message,
        string $timestamp,
        array $metadata = []
    ) {
        $this->bucketId = $bucketId;
        $this->message = $message;
        $this->timestamp = $timestamp;
        $this->metadata = $metadata;
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        return [
            'bucket_id' => $this->bucketId,
            'message' => $this->message,
            'timestamp' => $this->timestamp,
            'metadata' => $this->metadata
        ];
    }
}