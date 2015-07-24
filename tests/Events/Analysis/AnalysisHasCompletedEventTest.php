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

use Exception;
use StyleCI\StyleCI\Events\Analysis\AnalysisHasCompletedEvent;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the analysis has completed event test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalysisHasCompletedEventTest extends AbstractAnalysisEventTestCase
{
    protected function getObjectAndParams()
    {
        $params = ['analysis' => new Analysis(), 'exception' => new Exception()];
        $object = new AnalysisHasCompletedEvent($params['analysis'], $params['exception']);

        return compact('params', 'object');
    }
}
