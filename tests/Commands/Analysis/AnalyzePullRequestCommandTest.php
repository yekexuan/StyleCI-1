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

use StyleCI\StyleCI\Commands\Analysis\AnalyzePullRequestCommand;
use StyleCI\StyleCI\Handlers\Commands\Analysis\AnalyzePullRequestCommandHandler;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\Tests\StyleCI\Commands\AbstractCommandTestCase;

/**
 * This is the analyze pull request command test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalyzePullRequestCommandTest extends AbstractCommandTestCase
{
    protected function getObjectAndParams()
    {
        $params = ['repo' => new Repo(), 'pr' => 123, 'commit' => 'trololol', 'message' => 'SUP!'];
        $object = new AnalyzePullRequestCommand($params['repo'], $params['pr'], $params['commit'], $params['message']);

        return compact('params', 'object');
    }

    protected function objectHasRules()
    {
        return true;
    }

    protected function getHandlerClass()
    {
        return AnalyzePullRequestCommandHandler::class;
    }
}
