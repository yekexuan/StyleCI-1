<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Handlers\Events\Repo\GitHub;

use StyleCI\StyleCI\Commands\Analysis\AnalyseCommitCommand;
use StyleCI\StyleCI\Events\Repo\GitHub\GitHubPushEvent;
use StyleCI\StyleCI\Handlers\Events\Repo\GitHub\GitHubPushHandler;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the github public handler test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GitHubPushHandlerTest extends AbstractTestCase
{
    public function testHandlePushCommit()
    {
        $this->expectsJobs(AnalyseCommitCommand::class);

        $data = json_decode(file_get_contents(__DIR__.'/stubs/push-1.json'), true);
        $handler = new GitHubPushHandler();

        $this->assertNull($handler->handle(new GitHubPushEvent(new Repo(), $data)));
    }

    public function testHandlePushPages()
    {
        $this->expectsJobs([]);

        $data = json_decode(file_get_contents(__DIR__.'/stubs/push-2.json'), true);
        $handler = new GitHubPushHandler();

        $this->assertNull($handler->handle(new GitHubPushEvent(new Repo(), $data)));
    }

    public function testHandlePushTag()
    {
        $this->expectsJobs([]);

        $data = json_decode(file_get_contents(__DIR__.'/stubs/push-3.json'), true);
        $handler = new GitHubPushHandler();

        $this->assertNull($handler->handle(new GitHubPushEvent(new Repo(), $data)));
    }

    public function testHandleDeleteBranch()
    {
        $this->expectsJobs([]);

        $data = json_decode(file_get_contents(__DIR__.'/stubs/push-4.json'), true);
        $handler = new GitHubPushHandler();

        $this->assertNull($handler->handle(new GitHubPushEvent(new Repo(), $data)));
    }
}
