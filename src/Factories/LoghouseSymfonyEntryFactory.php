<?php

namespace LoghouseIo\LoghouseSymfony\Factories;


use LoghouseIo\LoghouseSymfony\Models\LoghouseSymfonyEntryImpl;
use LoghouseIo\LoghouseSymfony\Models\LoghouseSymfonyEntry;
use LoghouseIo\LoghouseSymfony\Utils\LoghouseSymfonyUtils;

/**
 * Class LoghouseSymfonyEntryFactory
 * @package LoghouseIo\LoghouseSymfony\Factories
 */
class LoghouseSymfonyEntryFactory
{
    /**
     * @param string $bucketId
     * @param string $message
     * @param array $metadata
     * @return LoghouseSymfonyEntry
     */
    public static function create(
        string $bucketId,
        string $message,
        array $metadata = []
    ): LoghouseSymfonyEntry {
        return new LoghouseSymfonyEntryImpl($bucketId, $message, LoghouseSymfonyUtils::getDataNowISO8061(), $metadata);
    }
}