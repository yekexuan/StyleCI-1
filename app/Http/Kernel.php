<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Http;

use Fideloper\Proxy\TrustProxies;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use StyleCI\StyleCI\Http\Middleware\CheckForMaintenanceMode;
use StyleCI\StyleCI\Http\Middleware\EtagMiddleware;

/**
 * This is the http kernel class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var string[]
     */
    protected $middleware = [TrustProxies::class, CheckForMaintenanceMode::class, EtagMiddleware::class];
}
