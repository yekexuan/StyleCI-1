<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events\Analysis;

use StyleCI\StyleCI\Events\Analysis\AnalysisHasCompletedEvent;
use StyleCI\StyleCI\Jobs\Analysis\CleanupAnalysisJob;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the cleanup handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CleanupHandler
{
    /**
     * Handle the analysis has completed event.
     *
     * We have a 1 in 8 chance of performing a cleanup.
     *
     * @param \StyleCI\StyleCI\Events\Analysis\AnalysisHasCompletedEvent $event
     *
     * @return void
     */
    public function handle(AnalysisHasCompletedEvent $event)
    {
        if (random_int(0, 7) > 0) {
            return;
        }

        foreach (Analysis::old()->pending()->orderBy('created_at', 'asc')->get() as $analysis) {
            dispatch(new CleanupAnalysisJob($analysis));
        }
    }
}
