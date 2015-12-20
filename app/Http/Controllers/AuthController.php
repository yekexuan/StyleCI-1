<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use StyleCI\Login\LoginProvider;
use StyleCI\StyleCI\Commands\User\LoginCommand;
use StyleCI\StyleCI\Http\Middleware\RedirectIfAuthenticated;
use StyleCI\StyleCI\Repositories\RepoRepository;

/**
 * This is the auth controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class AuthController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(RedirectIfAuthenticated::class, ['except' => ['handleLogout']]);
    }

    /**
     * Connect to the GitHub provider using OAuth.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleLogin()
    {
        return app(LoginProvider::class)->redirect(['admin:repo_hook', 'public_repo', 'read:org', 'user:email']);
    }

    /**
     * Handle the callback from GitHub.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleCallback()
    {
        $user = app(LoginProvider::class)->user();

        $username = array_get($user, 'login');
        $name = Str::name(array_get($user, 'name') ?: $username);

        dispatch(new LoginCommand((int) $user['id'], $name, $username, array_get($user, 'email'), array_get($user, 'token')));

        if (count(app(RepoRepository::class)->allByUser(Auth::user())) > 0) {
            return Redirect::route('home');
        }

        return Redirect::route('account');
    }

    /**
     * Logout a user account.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleLogout()
    {
        Auth::logout();

        return Redirect::route('home');
    }
}
