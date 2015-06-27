<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Http\Routes;

use Illuminate\Contracts\Routing\Registrar;

/**
 * This is the main routes class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class MainRoutes
{
    /**
     * Define the main routes.
     *
     * @param \Illuminate\Contracts\Routing\Registrar $router
     *
     * @return void
     */
    public function map(Registrar $router)
    {
        $router->get('/', [
            'as'   => 'home',
            'uses' => 'HomeController@handle',
        ]);

        $router->post('github-callback', [
            'as'   => 'webhook_callback',
            'uses' => 'GitHubController@handle',
        ]);

        $router->get('donate', [
            'as'   => 'donate',
            'uses' => 'PaypalController@handleDonate',
        ]);

        $router->get('donate/thanks', [
            'as'   => 'donate_thanks',
            'uses' => 'PaypalController@handleThanks',
        ]);

        $router->get('donate/cancel', [
            'as'   => 'donate_cancel',
            'uses' => 'PaypalController@handleCancel',
        ]);

        $router->get('privacy', [
            'as'   => 'privacy_policy',
            'uses' => 'HomeController@handlePrivacy',
        ]);

        $router->get('security', [
            'as'   => 'security_policy',
            'uses' => 'HomeController@handleSecurity',
        ]);

        $router->get('terms', [
            'as'   => 'terms_of_service',
            'uses' => 'HomeController@handleTerms',
        ]);

        $router->get('about', [
            'as'   => 'about_us',
            'uses' => 'HomeController@handleAbout',
        ]);
    }
}
