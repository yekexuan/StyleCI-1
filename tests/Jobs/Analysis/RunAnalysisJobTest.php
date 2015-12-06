<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Jobs\Analysis;

use AltThree\TestBench\JobTrait;
use StyleCI\StyleCI\Events\Analysis\AnalysisWasQueuedEvent;
use StyleCI\StyleCI\Jobs\Analysis\RunAnalysisJob;
use StyleCI\StyleCI\Models\Analysis;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the run analysis job test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RunAnalysisJobTest extends AbstractTestCase
{
    use JobTrait;

    protected function getObjectAndParams()
    {
        $this->expectsEvents(AnalysisWasQueuedEvent::class);

        $params = ['analysis' => new Analysis()];
        $object = new RunAnalysisJob($params['analysis']);

        return compact('params', 'object');
    }
}
