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

use StyleCI\StyleCI\Commands\Analysis\AnalyseCommitCommand;
use StyleCI\StyleCI\Handlers\Commands\Analysis\AnalyseCommitCommandHandler;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\Tests\StyleCI\Commands\AbstractCommandTestCase;

/**
 * This is the analyse commit command test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalyseCommitCommandTest extends AbstractCommandTestCase
{
    protected function getCommandObjectAndParams()
    {
        $params = ['repo' => new Repo(), 'branch' => 'foo', 'commit' => 'sha1 goes here', 'message' => 'Hi there!'];
        $object = new AnalyseCommitCommand($params['repo'], $params['branch'], $params['commit'], $params['message']);

        return compact('params', 'object');
    }

    protected function commandHasRules()
    {
        return true;
    }

    protected function getHandlerClass()
    {
        return AnalyseCommitCommandHandler::class;
    }
}
