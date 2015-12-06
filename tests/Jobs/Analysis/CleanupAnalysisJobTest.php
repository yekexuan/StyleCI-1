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
use StyleCI\StyleCI\Jobs\Analysis\CleanupAnalysisJob;
use StyleCI\StyleCI\Models\Analysis;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the run analysis job test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CleanupAnalysisJobTest extends AbstractTestCase
{
    use JobTrait;

    protected function getObjectAndParams()
    {
        $params = ['analysis' => new Analysis()];
        $object = new CleanupAnalysisJob($params['analysis']);

        return compact('params', 'object');
    }
}
