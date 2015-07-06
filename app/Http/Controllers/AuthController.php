<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use StyleCI\Login\LoginProvider;
use StyleCI\StyleCI\Commands\User\LoginCommand;

/**
 * This is the auth controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
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
     * @return \Illuminate\Http\Response
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

        $username = array_get($user, 'login');
        $name = Str::name(array_get($user, 'name') ?: $username);

        $this->dispatch(new LoginCommand((int) $user['id'], $name, $username, array_get($user, 'email'), array_get($user, 'token')));

        return Redirect::route('repos_path');
    }

    /**
     * Logout a user account.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleLogout()
    {
        Auth::logout();

        return Redirect::route('home');
    }
}
