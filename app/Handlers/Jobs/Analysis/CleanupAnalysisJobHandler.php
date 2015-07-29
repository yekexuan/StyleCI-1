<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Jobs\Analysis;

use StyleCI\StyleCI\Events\Analysis\AnalysisHasCompletedEvent;
use StyleCI\StyleCI\Jobs\Analysis\CleanupAnalysisJob;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the cleanup analysis job handler.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CleanupAnalysisJobHandler
{
    /**
     * Handle the cleanup analysis job.
     *
     * @param \StyleCI\StyleCI\Jobs\Analysis\CleanupAnalysisJob $job
     *
     * @return void
     */
    public function handle(CleanupAnalysisJob $job)
    {
        $analysis = $job->analysis;

        $analysis->status = Analysis::TIMEOUT;
        $analysis->save();

        event(new AnalysisHasCompletedEvent($analysis));
    }
}
