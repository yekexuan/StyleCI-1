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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * This is the authenticate middleware class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class Authenticate
{
    /**
     * The allowed user ids.
     *
     * @var array
     */
    protected $allowed;

    /**
     * Create a new authenticate middleware instance.
     *
     * @param int[] $allowed
     *
     * @return void
     */
    public function __construct(array $allowed)
    {
        $this->allowed = $allowed;
    }

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
        if (Auth::guest()) {
            throw new HttpException(401);
        }

        if (count($this->allowed) > 0 && !in_array(Auth::user()->id, $this->allowed)) {
            Auth::logout();

            return Redirect::route('home')->with('error', 'Your account has not been whitelisted.');
        }

        return $next($request);
    }
}
