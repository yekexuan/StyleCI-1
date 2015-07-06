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
     * Define the repo routes.
     *
     * @param \Illuminate\Contracts\Routing\Registrar $router
     *
     * @return void
     */
    public function map(Registrar $router)
    {
        $router->get('repos', [
            'as'   => 'repos_path',
            'uses' => 'RepoController@handleList',
        ]);

        $router->get('repos/{repo}', [
            'as'   => 'repo_path',
            'uses' => 'RepoController@handleShow',
        ]);

        $router->get('repos/{repo}/shield', [
            'as'   => 'repo_shield_path',
            'uses' => 'ShieldController@handle',
        ]);

        $router->get('analyses/{analysis}', [
            'as'   => 'analysis_path',
            'uses' => 'AnalysisController@handleShow',
        ]);

        $router->get('analyses/{analysis}/diff', [
            'as'   => 'analysis_diff_path',
            'uses' => 'AnalysisController@handleDiff',
        ]);

        $router->get('analyses/{analysis}/diff/download', [
            'as'   => 'analysis_download_path',
            'uses' => 'AnalysisController@handleDiffDownload',
        ]);
    }
}
