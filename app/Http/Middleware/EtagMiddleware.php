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

/**
 * This is the etag middleware class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class EtagMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // set etags for json responses
        if (in_array($response->getStatusCode(), [200, 201], true) && $response->headers->get('Content-Type') === 'application/json') {
            $response->setEtag(md5($response->getContent()));
            $response->setPublic();
        }

        // symfony turns the response into 304 for us just by us asking isNotModified
        if ($response->isNotModified($request)) {
            return $response;
        }

        return $response;
    }
}
