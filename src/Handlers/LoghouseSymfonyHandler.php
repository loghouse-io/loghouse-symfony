<?php

namespace LoghouseIo\LoghouseSymfony\Handlers;


use LoghouseIo\LoghouseSymfony\LoghouseSymfony;
use LoghouseIo\LoghouseSymfony\Models\LoghouseSymfonyConfigImpl;
use LoghouseIo\LoghouseSymfony\Models\LoghouseSymfonyEntriesStorageImpl;
use LoghouseIo\LoghouseSymfony\Utils\LoghouseSymfonyUtils;
use Monolog\Handler\AbstractProcessingHandler;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use LoghouseIo\LoghouseSymfony\Factories\LoghouseSymfonyEntryFactory;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class LoghouseSymfonyHandler
 * @package LoghouseIo\LoghouseSymfony\Handlers
 */
class LoghouseSymfonyHandler extends AbstractProcessingHandler
{
    /**
     * @var LoghouseSymfony
     */
    private $loghouseSymfony;

    /**
     * LoghouseSymfonyHandler constructor.
     * @param EventDispatcherInterface $eventDispatcher
     * @param string $accessToken
     * @param string $bucketId
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, string $accessToken, string $bucketId)
    {
        $isConsole = \PHP_SAPI === 'cli' || \PHP_SAPI === 'phpdbg';

        $this->loghouseSymfony = new LoghouseSymfony(
            new LoghouseSymfonyConfigImpl($isConsole, $accessToken, $bucketId),
            new LoghouseSymfonyEntriesStorageImpl
        );

        if (!$isConsole) {
            $eventDispatcher->addListener(KernelEvents::TERMINATE, function () {
                $this->loghouseSymfony->send();
            });
        }
    }

    protected function write(array $record): void
    {
        $metadata = [
            'level' => strtolower($record['level_name'])
        ];

        $context = $record['context'];

        if (!empty($context)) {
            if (isset($context['exception'])) {

                $metadata['error'] = [
                    'caught' => false,
                    'message' => $context['exception']->getMessage(),
                    'stacktrace' => $context['exception']->getTraceAsString()
                ];

                unset($context['exception']);

            } elseif (isset($context['error'])) {
                if ($context['error'] instanceof \Throwable) {

                    $metadata['error'] = [
                        'caught' => true,
                        'message' => $context['error']->getMessage(),
                        'stacktrace' => $context['error']->getTraceAsString()
                    ];

                } elseif (is_string($context['error'])) {

                    $metadata['error'] = [
                        'caught' => null,
                        'message' => $context['error']
                    ];
                }

                unset($context['error']);
            }
        }

        $metadata = array_merge($context, $metadata);
        $this->loghouseSymfony->log($record['message'], $metadata);
    }
}