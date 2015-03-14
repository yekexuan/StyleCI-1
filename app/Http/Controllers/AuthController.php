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
use StyleCI\Login\LoginProvider;
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
     * @param \StyleCI\Login\LoginProvider $login
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleLogin(LoginProvider $login)
    {
        return $login->redirect();
    }

    /**
     * Get the user access token to save notifications.
     *
     * @param \StyleCI\Login\LoginProvider $login
     *
     * @return \Illuminate\Http\Response
     */
    public function handleCallback(LoginProvider $login)
    {
        $user = $login->user();

        $this->dispatch(new LoginCommand(array_get($user, 'id'), array_get($user, 'name'), array_get($user, 'login'), array_get($raw, 'email'), array_get($raw, 'token')));

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
