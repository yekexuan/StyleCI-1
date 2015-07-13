<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events\Repo\GitHub;

use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use Psr\Log\LoggerInterface;
use StyleCI\StyleCI\Events\Repo\GitHub\GitHubPingEvent;

/**
 * This is the github ping handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GitHubPingHandler
{
    /**
     * The logger instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Create a new github ping handler instance.
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
     * Handle the github ping event.
     *
     * @param \StyleCI\StyleCI\Events\Repo\GitHub\GitHubPingEvent $event
     *
     * @return void
     */
    public function handle(GitHubPingEvent $event)
    {
        $repo = $event->repo;

        $this->logger->info('Received ping from GitHub.', ['data' => $event->data, 'repo' => AutoPresenter::decorate($repo)->toArray()]);
    }
}
