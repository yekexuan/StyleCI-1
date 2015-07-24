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

use StyleCI\StyleCI\Commands\Analysis\AnalyzeBranchCommand;
use StyleCI\StyleCI\Handlers\Commands\Analysis\AnalyzeBranchCommandHandler;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\Tests\StyleCI\Commands\AbstractCommandTestCase;

/**
 * This is the analyze branch command test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalyzeBranchCommandTest extends AbstractCommandTestCase
{
    protected function getObjectAndParams()
    {
        $params = ['repo' => new Repo(), 'branch' => 'master'];
        $object = new AnalyzeBranchCommand($params['repo'], $params['branch']);

        return compact('params', 'object');
    }

    protected function objectHasRules()
    {
        return true;
    }

    protected function getHandlerClass()
    {
        return AnalyzeBranchCommandHandler::class;
    }
}
