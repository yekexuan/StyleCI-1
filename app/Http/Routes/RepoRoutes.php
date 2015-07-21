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
 * This is the repo routes class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RepoRoutes
{
    /**
     * Defines if these routes are for the browser.
     *
     * @var bool
     */
    public static $browser = true;

    /**
     * Define the repo routes.
     *
     * @param \Illuminate\Contracts\Routing\Registrar $router
     *
     * @return void
     */
    public function map(Registrar $router)
    {
        $router->get('repos/{repo}', [
            'as'   => 'repo',
            'uses' => 'RepoController@handleShow',
        ]);

        $router->get('repos/{repo}/shield', [
            'as'   => 'repo_shield',
            'uses' => 'ShieldController@handle',
        ]);

        $router->get('analyses/{analysis}', [
            'as'   => 'analysis',
            'uses' => 'RepoController@handleAnalysis',
        ]);

        $router->get('analyses/{analysis}/diff', [
            'as'   => 'analysis_diff',
            'uses' => 'RepoController@handleDiff',
        ]);

        $router->get('analyses/{analysis}/diff/download', [
            'as'   => 'analysis_download',
            'uses' => 'RepoController@handleDiffDownload',
        ]);
    }
}
