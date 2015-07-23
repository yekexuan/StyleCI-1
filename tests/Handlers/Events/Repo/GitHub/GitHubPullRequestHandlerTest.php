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

use StyleCI\StyleCI\Commands\Analysis\AnalysePullRequestCommand;
use StyleCI\StyleCI\Events\Repo\GitHub\GitHubPullRequestEvent;
use StyleCI\StyleCI\Handlers\Events\Repo\GitHub\GitHubPullRequestHandler;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the github public handler test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GitHubPullRequestHandlerTest extends AbstractTestCase
{
    public function testHandleOriginOpen()
    {
        $this->expectsJobs([]);

        $data = json_decode(file_get_contents(__DIR__.'/stubs/pull-request-1.json'), true);
        $handler = new GitHubPullRequestHandler();

        $this->assertNull($handler->handle(new GitHubPullRequestEvent(new Repo(), $data)));
    }

    public function testHandleOriginClose()
    {
        $this->expectsJobs([]);

        $data = json_decode(file_get_contents(__DIR__.'/stubs/pull-request-2.json'), true);
        $handler = new GitHubPullRequestHandler();

        $this->assertNull($handler->handle(new GitHubPullRequestEvent(new Repo(), $data)));
    }

    public function testHandleOriginReopen()
    {
        $this->expectsJobs(AnalysePullRequestCommand::class);

        $data = json_decode(file_get_contents(__DIR__.'/stubs/pull-request-3.json'), true);
        $handler = new GitHubPullRequestHandler();

        $this->assertNull($handler->handle(new GitHubPullRequestEvent(new Repo(), $data)));
    }

    public function testHandleOriginSync()
    {
        $this->expectsJobs([]);

        $data = json_decode(file_get_contents(__DIR__.'/stubs/pull-request-4.json'), true);
        $handler = new GitHubPullRequestHandler();

        $this->assertNull($handler->handle(new GitHubPullRequestEvent(new Repo(), $data)));
    }

    public function testHandleOriginMerged()
    {
        $this->expectsJobs([]);

        $data = json_decode(file_get_contents(__DIR__.'/stubs/pull-request-5.json'), true);
        $handler = new GitHubPullRequestHandler();

        $this->assertNull($handler->handle(new GitHubPullRequestEvent(new Repo(), $data)));
    }

    public function testHandleRemoteOpen()
    {
        $this->expectsJobs(AnalysePullRequestCommand::class);

        $data = json_decode(file_get_contents(__DIR__.'/stubs/pull-request-6.json'), true);
        $handler = new GitHubPullRequestHandler();

        $this->assertNull($handler->handle(new GitHubPullRequestEvent(new Repo(), $data)));
    }

    public function testHandleRemoteClose()
    {
        $this->expectsJobs([]);

        $data = json_decode(file_get_contents(__DIR__.'/stubs/pull-request-7.json'), true);
        $handler = new GitHubPullRequestHandler();

        $this->assertNull($handler->handle(new GitHubPullRequestEvent(new Repo(), $data)));
    }

    public function testHandleRemoteReopen()
    {
        $this->expectsJobs(AnalysePullRequestCommand::class);

        $data = json_decode(file_get_contents(__DIR__.'/stubs/pull-request-8.json'), true);
        $handler = new GitHubPullRequestHandler();

        $this->assertNull($handler->handle(new GitHubPullRequestEvent(new Repo(), $data)));
    }

    public function testHandleRemotePages()
    {
        $this->expectsJobs([]);

        $data = json_decode(file_get_contents(__DIR__.'/stubs/pull-request-9.json'), true);
        $handler = new GitHubPullRequestHandler();

        $this->assertNull($handler->handle(new GitHubPullRequestEvent(new Repo(), $data)));
    }
}
