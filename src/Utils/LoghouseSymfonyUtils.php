<?php

namespace LoghouseIo\LoghouseSymfony\Utils;

use DateTime;
use DateTimeZone;

/**
 * Class LoghouseSymfonyUtils
 * @package LoghouseIo\LoghouseSymfony\Utils
 */
class LoghouseSymfonyUtils
{
    /**
     * @return string
     */
    public static function getDataNowISO8061(): string
    {
        $dateTime = new DateTime('now', new DateTimeZone('UTC'));
        return sprintf('%s.%sZ',
            explode('+', $dateTime->format('c'))[0],
            $dateTime->format('v')
        );
    }
}