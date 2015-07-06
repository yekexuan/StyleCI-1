<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Providers;

use GrahamCampbell\TestBenchCore\LaravelTrait;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;
use StyleCI\StyleCI\GitHub\Branches;
use StyleCI\StyleCI\GitHub\ClientFactory;
use StyleCI\StyleCI\GitHub\Collaborators;
use StyleCI\StyleCI\GitHub\Commits;
use StyleCI\StyleCI\GitHub\Hooks;
use StyleCI\StyleCI\GitHub\Repos;
use StyleCI\StyleCI\GitHub\Status;
use StyleCI\StyleCI\GitHub\Tokens;
use StyleCI\StyleCI\Providers\GitHubServiceProvider;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the github service provider test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GitHubServiceProviderTest extends AbstractTestCase
{
    use LaravelTrait, ServiceProviderTrait;

    protected function getServiceProviderClass($app)
    {
        return GitHubServiceProvider::class;
    }

    public function testClientFactoryIsInjectable()
    {
        $this->assertIsInjectable(ClientFactory::class);
    }

    /**
     * @depends testClientFactoryIsInjectable
     */
    public function testBranchesIsInjectable()
    {
        $this->assertIsInjectable(Branches::class);
    }

    /**
     * @depends testClientFactoryIsInjectable
     */
    public function testCollaboratorsIsInjectable()
    {
        $this->assertIsInjectable(Collaborators::class);
    }

    /**
     * @depends testClientFactoryIsInjectable
     */
    public function testCommitsIsInjectable()
    {
        $this->assertIsInjectable(Commits::class);
    }

    /**
     * @depends testClientFactoryIsInjectable
     */
    public function testHooksIsInjectable()
    {
        $this->assertIsInjectable(Hooks::class);
    }

    /**
     * @depends testClientFactoryIsInjectable
     */
    public function testReposIsInjectable()
    {
        $this->assertIsInjectable(Repos::class);
    }

    /**
     * @depends testClientFactoryIsInjectable
     */
    public function testStatusIsInjectable()
    {
        $this->assertIsInjectable(Status::class);
    }

    /**
     * @depends testClientFactoryIsInjectable
     */
    public function testTokensIsInjectable()
    {
        $this->assertIsInjectable(Tokens::class);
    }
}
