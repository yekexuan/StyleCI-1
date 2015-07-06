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
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the cleanup analysis job.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CleanupAnalysisJob implements ShouldQueue
{
    use SerializesModels;

    /**
     * The analysis to cleanup.
     *
     * @var \StyleCI\StyleCI\Models\Analysis
     */
    public $analysis;

    /**
     * Create a new cleanup analysis job instance.
     *
     * @param \StyleCI\StyleCI\Models\Analysis $analysis
     *
     * @return void
     */
    public function __construct(Analysis $analysis)
    {
        $this->analysis = $analysis;
    }
}
