<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\Tests\StyleCI\Providers;

use GrahamCampbell\TestBenchCore\LaravelTrait;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;
use StyleCI\StyleCI\Providers\RepositoryServiceProvider;
use StyleCI\StyleCI\Repositories\RepoRepository;
use StyleCI\StyleCI\Repositories\UserRepository;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the repository service provider test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RepositoryServiceProviderTest extends AbstractTestCase
{
    use LaravelTrait, ServiceProviderTrait;

    protected function getServiceProviderClass($app)
    {
        return RepositoryServiceProvider::class;
    }

    public function testRepoRepositoryIsInjectable()
    {
        $this->assertIsInjectable(RepoRepository::class);
    }

    public function testUserRepositoryIsInjectable()
    {
        $this->assertIsInjectable(UserRepository::class);
    }
}
