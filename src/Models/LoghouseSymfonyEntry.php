<?php

namespace LoghouseIo\LoghouseSymfony\Models;

/**
 * Interface LoghouseSymfonyEntry
 * @package LoghouseIo\LoghouseSymfony\Models
 */
interface LoghouseSymfonyEntry
{
    /**
     * @return array
     */
    public function serialize(): array;
}