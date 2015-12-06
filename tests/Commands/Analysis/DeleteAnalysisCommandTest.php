<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Commands\Analysis;

use AltThree\TestBench\CommandTrait;
use StyleCI\StyleCI\Commands\Analysis\DeleteAnalysisCommand;
use StyleCI\StyleCI\Handlers\Commands\Analysis\DeleteAnalysisCommandHandler;
use StyleCI\StyleCI\Models\Analysis;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the delete analysis command test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class DeleteAnalysisCommandTest extends AbstractTestCase
{
    use CommandTrait;

    protected function getObjectAndParams()
    {
        $params = ['analysis' => new Analysis()];
        $object = new DeleteAnalysisCommand($params['analysis']);

        return compact('params', 'object');
    }

    protected function getHandlerClass()
    {
        return DeleteAnalysisCommandHandler::class;
    }
}
