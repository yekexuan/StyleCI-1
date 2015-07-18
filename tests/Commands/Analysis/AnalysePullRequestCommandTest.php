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

use StyleCI\StyleCI\Commands\Analysis\AnalysePullRequestCommand;
use StyleCI\StyleCI\Handlers\Commands\Analysis\AnalysePullRequestCommandHandler;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\Tests\StyleCI\Commands\AbstractCommandTestCase;

/**
 * This is the analyse pull request command test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalysePullRequestCommandTest extends AbstractCommandTestCase
{
    protected function getCommandObjectAndParams()
    {
        $params = ['repo' => new Repo(), 'pr' => 123, 'commit' => 'trololol', 'message' => 'SUP!'];
        $object = new AnalysePullRequestCommand($params['repo'], $params['pr'], $params['commit'], $params['message']);

        return compact('params', 'object');
    }

    protected function commandHasRules()
    {
        return true;
    }

    protected function getHandlerClass()
    {
        return AnalysePullRequestCommandHandler::class;
    }
}
