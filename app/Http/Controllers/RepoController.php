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
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use StyleCI\StyleCI\GitHub\Repos;
use StyleCI\StyleCI\Models\Analysis;
use StyleCI\StyleCI\Models\Repo;

/**
 * This is the repo controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RepoController extends Controller
{
    /**
     * Handles the request to show a repo.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     *
     * @return \Illuminate\View\View
     */
    public function handleShow(Repo $repo)
    {
        if ($user = Auth::user()) {
            $canAnalyze = (bool) array_get(app(Repos::class)->get($user), $repo->id);
        } else {
            $canAnalyze = false;
        }

        return View::make('repos.repo')->withRepo($repo)->withCanAnalyze($canAnalyze);
    }

    /**
     * Handles a request to serve a shield.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     *
     * @return \Illuminate\Http\Response
     */
    public function handleShield(Repo $repo)
    {
        $style = Request::get('style');

        if (!in_array($style, ['flat', 'flat-square', 'plastic'], true)) {
            $style = 'flat-square';
        }

        $analysis = $repo->last_completed;

        $status = $analysis ? strtolower(AutoPresenter::decorate($analysis)->summary) : 'unknown';

        $data = file_get_contents(base_path("resources/assets/svg/shields/{$style}/{$status}.svg"));

        return Response::make($data, 200, ['Content-Type' => 'image/svg+xml']);
    }

    /**
     * Handles the request to show an analysis.
     *
     * @param \StyleCI\StyleCI\Models\Analysis $analysis
     *
     * @return \Illuminate\View\View
     */
    public function handleAnalysis(Analysis $analysis)
    {
        return View::make('analysis.index')->withAnalysis($analysis);
    }

    /**
     * Handles the request to show a diff.
     *
     * @param \StyleCI\StyleCI\Models\Analysis $analysis
     *
     * @return \Illuminate\Http\Response
     */
    public function handleDiff(Analysis $analysis)
    {
        return Response::make(AutoPresenter::decorate($analysis)->raw_diff)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    /**
     * Handles the request to download a diff.
     *
     * @param \StyleCI\StyleCI\Models\Analysis $analysis
     *
     * @return \Illuminate\Http\Response
     */
    public function handleDiffDownload(Analysis $analysis)
    {
        return Response::make(AutoPresenter::decorate($analysis)->raw_diff)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename=patch.txt');
    }
}
