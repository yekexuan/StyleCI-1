<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events\Repo;

use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use Psr\Log\LoggerInterface;
use StyleCI\StyleCI\Events\Repo\RepoEventInterface;
use StyleCI\StyleCI\Events\Repo\RepoWasDisabledEvent;
use StyleCI\StyleCI\Models\Repo;

/**
 * This is the repo logging handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RepoLoggingHandler
{
    /**
     * The logger instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Create a new repo logging handler instance.
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
     * Handle the repo event.
     *
     * @param \StyleCI\StyleCI\Events\Repo\RepoEventInterface $event
     *
     * @return void
     */
    public function handle(RepoEventInterface $event)
    {
        $repo = $event->repo;

        if ($event instanceof RepoWasDisabledEvent) {
            $this->logger->debug('Repo has been disabled.', $this->getContext($repo));
        } else {
            $this->logger->debug('Repo has been enabled.', $this->getContext($repo));
        }
    }

    /**
     * Get the context.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     *
     * @return array
     */
    protected function getContext(Repo $repo)
    {
        return ['repo' => AutoPresenter::decorate($repo)->toArray()];
    }
}
