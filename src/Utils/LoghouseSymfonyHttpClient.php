<?php

namespace LoghouseIo\LoghouseSymfony\Utils;

/**
 * Class LoghouseSymfonyHttpClient
 * @package LoghouseIo\LoghouseSymfony
 */
class LoghouseSymfonyHttpClient
{
    private const URL = 'https://api.loghouse.io/log';

    /**
     * @param string $accessToken
     * @param array $entries
     */
    public static function send(string $accessToken, array $entries)
    {
        $ch = curl_init(self::URL);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'access_token' => $accessToken,
            'entries' => $entries
        ]));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}