<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Http\Routes;

use Illuminate\Contracts\Routing\Registrar;

/**
 * This is the account routes class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AccountRoutes
{
    /**
     * Defines if these routes are for the browser.
     *
     * @var bool
     */
    public static $browser = true;

    /**
     * Define the account routes.
     *
     * @param \Illuminate\Contracts\Routing\Registrar $router
     *
     * @return void
     */
    public function map(Registrar $router)
    {
        $router->post('auth/login', [
            'as'   => 'auth_login',
            'uses' => 'AuthController@handleLogin',
        ]);

        $router->get('auth/github-callback', [
            'as'   => 'auth_callback',
            'uses' => 'AuthController@handleCallback',
        ]);

        $router->post('auth/logout', [
            'as'   => 'auth_logout',
            'uses' => 'AuthController@handleLogout',
        ]);

        $router->get('account', [
            'as'   => 'account',
            'uses' => 'AccountController@handleShow',
        ]);

        $router->delete('account/delete', [
            'as'   => 'account_delete',
            'uses' => 'AccountController@handleDelete',
        ]);
    }
}
