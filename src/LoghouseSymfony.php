<?php

namespace LoghouseIo\LoghouseSymfony;

use DateTime;
use LoghouseIo\LoghouseSymfony\Exceptions\LoghouseSymfonyEntryValidateException;

class LoghouseSymfony
{
    const URL = 'https://api.loghouse.io/log';

    /**
     * @var ?string
     */
    private $accessToken;

    /**
     * @var ?string
     */
    private $defaultBucketId;

    /**
     * @var array
     */
    private $entries = [];

    /**
     * LoghouseSymfony constructor.
     */
    public function __construct(string $accessToken = null, string $defaultBucketId = null)
    {
        $this->accessToken = $accessToken;
        $this->defaultBucketId = $defaultBucketId;
    }

    /**
     * @param string|null $message
     * @param array|null $metadata
     * @param string|null $bucketId
     */
    public function log(
        string $message = null,
        array $metadata = [],
        string $bucketId = null): void
    {
        if (empty($this->accessToken)) {
            return;
        }

        $bucketId = $bucketId ?? $this->defaultBucketId;

        try {
            $this->entryValidate($bucketId, $message, $metadata);
        } catch (LoghouseSymfonyEntryValidateException $e) {
            return;
        }

        $this->addEntry($bucketId, $message, $metadata);
    }

    /**
     * @param string|null $bucketId
     * @param string|null $message
     * @param array|null $metadata
     * @throws LoghouseSymfonyEntryValidateException
     */
    private function entryValidate(
        string $bucketId = null,
        string $message = null,
        array $metadata = []
    ): void
    {
        if (empty($bucketId)) {
            throw new LoghouseSymfonyEntryValidateException('Empty bucket_id');
        }

        if (empty($message)) {
            throw new LoghouseSymfonyEntryValidateException('Empty message');
        }

        if (!is_array($metadata)) {
            throw new LoghouseSymfonyEntryValidateException('Metadata is not array');
        }
    }

    /**
     * @param string $bucketId
     * @param string $message
     * @param array $metadata
     */
    private function addEntry(
        string $bucketId,
        string $message,
        array $metadata = []
    ): void {

        $entry = [
            'bucket_id' => $bucketId,
            'message' => $message,
            'timestamp' => (new DateTime())->format('c')
        ];

        if (!empty($metadata)) {
            $entry['metadata'] = $metadata;
        }

        $this->entries[] = $entry;
    }

    public function send(): void
    {
        if (empty($this->accessToken) || count($this->entries) == 0) {
            return;
        }

        $ch = curl_init(self::URL);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'access_token' => $this->accessToken,
            'entries' => $this->entries
        ]));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}