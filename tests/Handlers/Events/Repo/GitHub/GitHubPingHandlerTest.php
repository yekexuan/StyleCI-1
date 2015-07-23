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

use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use Mockery;
use Psr\Log\LoggerInterface;
use StyleCI\StyleCI\Events\Repo\GitHub\GitHubPingEvent;
use StyleCI\StyleCI\Handlers\Events\Repo\GitHub\GitHubPingHandler;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the github ping handler test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GitHubPingHandlerTest extends AbstractTestCase
{
    public function testHandle()
    {
    	$data = json_decode(file_get_contents(__DIR__.'/stubs/ping.json'), true);
        $handler = new GitHubPingHandler($log = Mockery::mock(LoggerInterface::class));

        AutoPresenter::shouldReceive('decorate')->once()->with($repo = new Repo())->andReturn($presenter = Mockery::mock(RepoPresenter::class));
        $presenter->shouldReceive('toArray')->once()->andReturn($presented = ['id' => 26929642, 'name' => 'StyleCI/StyleCI']);
        $log->shouldReceive('info')->once()->with('Received ping from GitHub.', ['data' => $data, 'repo' => $presented]);

        $this->assertNull($handler->handle(new GitHubPingEvent($repo, $data)));
    }
}
