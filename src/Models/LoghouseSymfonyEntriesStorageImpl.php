<?php

namespace LoghouseIo\LoghouseSymfony\Models;

/**
 * Class LoghouseSymfonyEntriesStorageImpl
 * @package LoghouseIo\LoghouseSymfony\Models
 */
class LoghouseSymfonyEntriesStorageImpl implements LoghouseSymfonyEntriesStorage
{
    /**
     * @var array
     */
    private $entries = [];

    /**
     * @param LoghouseSymfonyEntry $entry
     */
    public function addEntry(LoghouseSymfonyEntry $entry): void
    {
        $this->entries[] = $entry;
    }

    /**
     * @return bool
     */
    public function hasEntries(): bool
    {
        return count($this->entries) > 0;
    }

    public function reset(): void
    {
        $this->entries = [];
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        if (!$this->hasEntries()) {
            return [];
        }

        return array_map(function ($entry) {
            return $entry->serialize();
        }, $this->entries);
    }
}