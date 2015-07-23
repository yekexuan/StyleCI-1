<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Models;

use Github\Client;
use GrahamCampbell\GitHub\GitHubFactory;
use GrahamCampbell\TestBenchCore\MockeryTrait;
use Mockery;
use StyleCI\StyleCI\GitHub\ClientFactory;
use StyleCI\StyleCI\Models\Analysis;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\StyleCI\Models\User;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the github client factory test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ClientFactoryTest extends AbstractTestCase
{
    use MockeryTrait;

    public function testMakeWithUser()
    {
        $factory = new ClientFactory($gh = Mockery::mock(GitHubFactory::class));
        $gh->shouldReceive('make')->once()
            ->with(['token' => 'gh-token', 'method' => 'token', 'version' => 'foo-bar'])
            ->andReturn(Mockery::mock(Client::class));

        $client = $factory->make(new User(['token' => 'gh-token']), ['version' => 'foo-bar']);

        $this->assertInstanceOf(Client::class, $client);
    }

    public function testMakeWithRepo()
    {
        $factory = new ClientFactory($gh = Mockery::mock(GitHubFactory::class));
        $gh->shouldReceive('make')->once()
            ->with(['token' => 'foo-bar-baz', 'method' => 'token'])
            ->andReturn(Mockery::mock(Client::class));

        $client = $factory->make((new Repo())->setRelation('user', new User(['token' => 'foo-bar-baz'])));

        $this->assertInstanceOf(Client::class, $client);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage You must provide a user or repo.
     */
    public function testMakeAndFail()
    {
        $factory = new ClientFactory(Mockery::mock(GitHubFactory::class));

        $factory->make(new Analysis());
    }
}
