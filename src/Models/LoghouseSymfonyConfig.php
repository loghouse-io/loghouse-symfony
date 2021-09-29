<?php

namespace LoghouseIo\LoghouseSymfony\Models;

/**
 * Interface LoghouseSymfonyConfig
 * @package LoghouseIo\LoghouseSymfony\Models
 */
interface LoghouseSymfonyConfig
{
    /**
     * @return bool
     */
    public function isConsole(): bool;

    /**
     * @return bool
     */
    public function hasValidCredentials(): bool;

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string;

    /**
     * @return string|null
     */
    public function getBucketId(): ?string;
}