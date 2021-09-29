<?php

namespace LoghouseIo\LoghouseSymfony\Models;

/**
 * Class LoghouseSymfonyConfigImpl
 * @package LoghouseIo\LoghouseSymfony\Models
 */
class LoghouseSymfonyConfigImpl implements LoghouseSymfonyConfig
{
    /**
     * @var bool
     */
    private $isConsole;

    /**
     * @var string|null
     */
    private $accessToken;

    /**
     * @var string|null
     */
    private $bucketId;

    /**
     * LoghouseSymfonyConfigImpl constructor.
     * @param bool $isConsole
     * @param string|null $accessToken
     */
    public function __construct(
        bool $isConsole,
        string $accessToken = null,
        string $bucketId = null
    ) {
        $this->isConsole = $isConsole;
        $this->accessToken = $accessToken;
        $this->bucketId = $bucketId;
    }

    /**
     * @return bool
     */
    public function isConsole(): bool
    {
        return $this->isConsole;
    }

    /**
     * @return bool
     */
    public function hasValidCredentials(): bool
    {
        return $this->accessToken && $this->bucketId;
    }

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * @return string|null
     */
    public function getBucketId(): ?string
    {
        return $this->bucketId;
    }
}