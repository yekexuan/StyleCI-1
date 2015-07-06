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
 * This is the api routes class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class ApiRoutes
{
    /**
     * Define the account routes.
     *
     * @param \Illuminate\Contracts\Routing\Registrar $router
     *
     * @return void
     */
    public function map(Registrar $router)
    {
        $router->group(['prefix' => 'api', 'as' => 'api_'], function (Registrar $router) {
            $router->get('repos', [
                'as'   => 'repos_path',
                'uses' => 'RepoController@handleList',
            ]);

            $router->get('repos/{repo}', [
                'as'   => 'repo_path',
                'uses' => 'RepoController@handleShow',
            ]);

            $router->post('repos/{repo}/analyse', [
                'as'   => 'repo_analyse_path',
                'uses' => 'RepoController@handleAnalyse',
            ]);

            $router->get('analyses/{analysis}', [
                'as'   => 'analysis_path',
                'uses' => 'AnalysisController@handleShow',
            ]);

            $router->get('account/repos', [
                'as'   => 'account_repos_path',
                'uses' => 'AccountController@handleListRepos',
            ]);

            $router->post('account/repos/sync', [
                'as'   => 'account_repos_sync_path',
                'uses' => 'AccountController@handleSync',
            ]);

            $router->post('account/enable/{id}', [
                'as'   => 'enable_repo_path',
                'uses' => 'AccountController@handleEnable',
            ]);

            $router->post('account/disable/{repo}', [
                'as'   => 'disable_repo_path',
                'uses' => 'AccountController@handleDisable',
            ]);
        });
    }
}
