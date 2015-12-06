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
use StyleCI\StyleCI\Commands\Analysis\AnalyzeCommitCommand;
use StyleCI\StyleCI\Handlers\Commands\Analysis\AnalyzeCommitCommandHandler;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the analyze commit command test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalyzeCommitCommandTest extends AbstractTestCase
{
    use CommandTrait;

    protected function getObjectAndParams()
    {
        $params = ['repo' => new Repo(), 'branch' => 'foo', 'commit' => 'sha1 goes here', 'message' => 'Hi there!'];
        $object = new AnalyzeCommitCommand($params['repo'], $params['branch'], $params['commit'], $params['message']);

        return compact('params', 'object');
    }

    protected function objectHasRules()
    {
        return true;
    }

    protected function getHandlerClass()
    {
        return AnalyzeCommitCommandHandler::class;
    }
}
