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

use Illuminate\Contracts\Queue\ShouldBeQueued;
use StyleCI\StyleCI\GitHub\Status;

/**
 * This is the commit status handler class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class CommitStatusHandler implements ShouldBeQueued
{
    /**
     * The status instance.
     *
     * @var \StyleCI\StyleCI\GitHub\Status
     */
    protected $status;

    /**
     * Create a new commit status handler instance.
     *
     * @param \StyleCI\StyleCI\GitHub\Status $status
     *
     * @return void
     */
    public function __construct(Status $status)
    {
        $this->status = $status;
    }

    /**
     * Handle the analysis has completed event.
     *
     * @param \StyleCI\StyleCI\Events\AnalysisHasCompletedEvent|\StyleCI\StyleCI\Events\AnalysisWasQueuedEvent $event
     *
     * @return void
     */
    public function handle($event)
    {
        $commit = $event->getCommit();

        $this->status->push($commit);
    }
}
