<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use StyleCI\StyleCI\Commands\Analysis\AnalyzeBranchCommand;
use StyleCI\StyleCI\GitHub\Branches;
use StyleCI\StyleCI\Http\Middleware\Authenticate;
use StyleCI\StyleCI\Models\Analysis;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\StyleCI\Repositories\RepoRepository;

/**
 * This is the repo controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joseph Cohen <joe@alt-three.com>
 */
class RepoController extends Controller
{
    use DispatchesJobs;

    /**
     * Create a new account controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(Authenticate::class, ['only' => ['handleList']]);
    }

    /**
     * Handles the request to list the repos.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleList()
    {
        $repos = app(RepoRepository::class)->allByUser(Auth::user());

        return new JsonResponse(['data' => AutoPresenter::decorate($repos)->toArray()]);
    }

    /**
     * Handles the request to show a repo.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleShow(Repo $repo)
    {
        $branch = Request::get('branch', $repo->default_branch);
        $analyses = $repo->analyses()->visible()->where('branch', $branch)->orderBy('created_at', 'desc')->paginate(50);

        $pagination = [
            'total'        => $analyses->total(),
            'count'        => count($analyses->items()),
            'per_page'     => $analyses->perPage(),
            'current_page' => $analyses->currentPage(),
            'total_pages'  => $analyses->lastPage(),
            'links'        => [
                'next_page'     => $analyses->nextPageUrl(),
                'previous_page' => $analyses->previousPageUrl(),
            ],
        ];

        return new JsonResponse(['data' => AutoPresenter::decorate($analyses->getCollection())->toArray(), 'pagination' => $pagination]);
    }

    /**
     * Handles the request to analyze a repo.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleAnalyze(Repo $repo)
    {
        $this->dispatch(new AnalyzeBranchCommand($repo, Request::get('branch')));

        return new JsonResponse(['queued' => true], 202);
    }

    /**
     * Handles the request to list a repo branches.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleBranches(Repo $repo)
    {
        $branches = collect(app(Branches::class)->get($repo))->lists('name')->all();

        return new JsonResponse(['data' => $branches]);
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
        return View::make('analysis.results')->withAnalysis($analysis);
    }
}
