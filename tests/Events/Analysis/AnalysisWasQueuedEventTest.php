<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Events\Analysis;

use StyleCI\StyleCI\Events\Analysis\AnalysisWasQueuedEvent;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the analysis was queued event test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalysisWasQueuedEventTest extends AbstractAnalysisEventTestCase
{
    protected function getObjectAndParams()
    {
        $params = ['analysis' => new Analysis()];
        $object = new AnalysisWasQueuedEvent($params['analysis']);

        return compact('params', 'object');
    }
}
