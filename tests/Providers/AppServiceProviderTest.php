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
use StyleCI\StyleCI\Http\Middleware\Authenticate;
use StyleCI\Tests\StyleCI\AbstractTestCase;

/**
 * This is the app service provider test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AppServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function testAuthenticateMiddlewareIsInjectable()
    {
        $this->assertIsInjectable(Authenticate::class);
    }
}
