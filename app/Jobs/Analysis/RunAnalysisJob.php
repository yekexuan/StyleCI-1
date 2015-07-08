<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Jobs\Analysis;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use StyleCI\StyleCI\Events\Analysis\AnalysisWasQueuedEvent;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the run analysis job.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
final class RunAnalysisJob implements ShouldQueue
{
    use SerializesModels;

    /**
     * The analysis object.
     *
     * @var \StyleCI\StyleCI\Models\Analysis
     */
    public $analysis;

    /**
     * Create a new run analysis job instance.
     *
     * @param \StyleCI\StyleCI\Models\Analysis $analysis
     *
     * @return void
     */
    public function __construct(Analysis $analysis)
    {
        $this->analysis = $analysis;

        event(new AnalysisWasQueuedEvent($analysis));
    }
}
