<?php

namespace LoghouseIo\LoghouseSymfony\Models;

/**
 * Interface LoghouseSymfonyEntriesStorage
 * @package LoghouseIo\LoghouseSymfony\Models
 */
interface LoghouseSymfonyEntriesStorage
{
    /**
     * @param LoghouseSymfonyEntry $entry
     */
    public function addEntry(LoghouseSymfonyEntry $entry): void;

    /**
     * @return bool
     */
    public function hasEntries(): bool;

    /**
     * @return array
     */
    public function serialize(): array;

    public function reset(): void;
}