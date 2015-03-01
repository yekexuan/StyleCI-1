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

        $username = $socialiteUser->nickname;
        $name = trim(preg_replace('/[^A-Za-z ]/', '', $socialiteUser->name ?: $username));

        $this->dispatch(new LoginCommand($socialiteUser->id, $name, $username, $socialiteUser->email, $socialiteUser->token));

        return Redirect::route('repos_path')->with('info', '<p class="lead">Our new config system is live!</p><p>You can read all about this over on our blog: <a href="https://blog.styleci.io/redefining-configuration" target="_blank">https://blog.styleci.io/redefining-configuration</a>.</p>');
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
