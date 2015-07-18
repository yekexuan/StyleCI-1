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

use Mockery;
use StyleCI\StyleCI\Commands\Analysis\AnalyseBranchCommand;
use StyleCI\StyleCI\Handlers\Commands\Analysis\AnalyseBranchCommandHandler;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\Tests\StyleCI\Commands\AbstractCommandTestCase;

/**
 * This is the analyse branch command test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalyseBranchCommandTest extends AbstractCommandTestCase
{
    protected function getCommandObjectAndParams()
    {
        $params = ['repo' => new Repo(), 'branch' => 'master'];
        $object = new AnalyseBranchCommand($params['repo'], $params['branch']);

        return compact('params', 'object');
    }

    protected function commandHasRules()
    {
        return true;
    }

    protected function getHandlerClass()
    {
        return AnalyseBranchCommandHandler::class;
    }
}
