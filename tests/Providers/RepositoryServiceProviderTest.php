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

use AltThree\TestBench\ServiceProviderTrait;
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
    use ServiceProviderTrait;

    public function testRepoRepositoryIsInjectable()
    {
        $this->assertIsInjectable(RepoRepository::class);
    }

    public function testUserRepositoryIsInjectable()
    {
        $this->assertIsInjectable(UserRepository::class);
    }
}
