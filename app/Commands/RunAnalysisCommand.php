<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Commands;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use StyleCI\StyleCI\Events\AnalysisWasQueuedEvent;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the run analysis command.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RunAnalysisCommand implements ShouldQueue
{
    use SerializesModels;

    /**
     * The analysis object.
     *
     * @var \StyleCI\StyleCI\Models\Analysis
     */
    public $analysis;

    /**
     * Create a new run analysis command instance.
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
