<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 * (c) Joseph Cohen <joseph.cohen@dinkbit.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\GithubProvider;
use StyleCI\StyleCI\Commands\LoginCommand;

/**
 * This is the auth controller class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 * @author Joseph Cohen <joseph.cohen@dinkbit.com>
 */
class AuthController extends AbstractController
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest', ['except' => ['handleLogout']]);
    }

    /**
     * Connect to the GitHub provider using OAuth.
     *
     * @param \Laravel\Socialite\GithubProvider $socialite
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleLogin(GithubProvider $socialite)
    {
        $socialite->scopes([
            'read:org',
            'user:email',
            'public_repo',
            'admin:repo_hook',
        ]);

        return $socialite->redirect();
    }

    /**
     * Get the user access token to save notifications.
     *
     * @param \Laravel\Socialite\GithubProvider $socialite
     *
     * @return \Illuminate\Http\Response
     */
    public function handleCallback(GithubProvider $socialite)
    {
        $socialiteUser = $socialite->user();

        $this->dispatch(new LoginCommand($socialiteUser->id, $socialiteUser->name, $socialiteUser->nickname, $socialiteUser->email, $socialiteUser->token));

        return Redirect::route('repos_path')->with('info', '<div class="container"><p class="lead">Please note that .php_cs config is currently disabled due to security concerns.</p><p>A replacement config system using a .styleci.yml file is coming very soon.</p></div>');
    }

    /**
     * Logout a user account.
     *
     * @param \Illuminate\Contracts\Auth\Guard $auth
     *
     * @return \Illuminate\Http\Response
     */
    public function handleLogout(Guard $auth)
    {
        $auth->logout();

        return Redirect::route('home');
    }
}
