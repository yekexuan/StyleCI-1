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
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * This is the body size middleware class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class BodySize
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
        // prevent body sizes of more than 1 MB
        if (mb_strlen($request->getContent(), '8bit') > 1048576) {
            throw new HttpException(413);
        }

        return $next($request);
    }
}
