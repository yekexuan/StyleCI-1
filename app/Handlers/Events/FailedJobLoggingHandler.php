<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events;

use Illuminate\Contracts\Queue\Job;
use Psr\Log\LoggerInterface;

/**
 * This is the failed job logging handler class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class FailedJobLoggingHandler
{
    /**
     * The presenter instance.
     *
     * @var \McCool\LaravelAutoPresenter\PresenterDecorator
     */
    protected $presenter;

    /**
     * Create a new failed job logging handler instance.
     *
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return void
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Handle the failed job event.
     *
     * @param string                          $connection
     * @param \Illuminate\Contracts\Queue\Job $job
     * @param array                           $data
     *
     * @return void
     */
    public function handle($connection, Job $job, array $data)
    {
        $this->logger->error('Queue job failed.', ['job' => ['id' => $job->getJobId(), 'connection' => $connection], 'data' => $data]);
    }
}
