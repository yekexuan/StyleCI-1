<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * This is the event header middleware class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class EventHeader
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // the header must be made from lower case letters and underscores
        // the header must also be between 4 and 27 characters long
        if (!preg_match('/^[a-z_]{4,27}$/', $request->header('X-GitHub-Event'))) {
            throw new BadRequestHttpException('Bad event header rejected.');
        }

        return $next($request);
    }
}
