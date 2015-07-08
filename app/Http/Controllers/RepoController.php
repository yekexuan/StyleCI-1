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

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use McCool\LaravelAutoPresenter\Facades\AutoPresenter;
use StyleCI\StyleCI\Commands\Analysis\AnalyseBranchCommand;
use StyleCI\StyleCI\GitHub\Branches;
use StyleCI\StyleCI\GitHub\Repos;
use StyleCI\StyleCI\Models\Repo;
use StyleCI\StyleCI\Repositories\RepoRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * This is the repo controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RepoController extends AbstractController
{
    /**
     * Create a new account controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth', ['except' => 'handleShow']);
    }

    /**
     * Handles the request to list the repos.
     *
     * @param \StyleCI\StyleCI\Repositories\RepoRepository $repoRepository
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function handleList(RepoRepository $repoRepository)
    {
        $repos = $repoRepository->allByUser(Auth::user());

        if (Request::ajax()) {
            return new JsonResponse(['data' => AutoPresenter::decorate($repos)->toArray()]);
        }

        return View::make('repos')->withRepos($repos);
    }

    /**
     * Handles the request to show a repo.
     *
     * @param \StyleCI\StyleCI\Models\Repo     $repo
     * @param \StyleCI\StyleCI\GitHub\Repos    $repos
     * @param \StyleCI\StyleCI\GitHub\Branches $branches
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function handleShow(Repo $repo, Repos $repos, Branches $branches)
    {
        $analyses = $repo->analyses()->where('branch', Request::get('branch', $repo->default_branch))->orderBy('created_at', 'desc')->paginate(50);

        if (Request::ajax()) {
            return new JsonResponse(['data' => AutoPresenter::decorate($analyses->getCollection())->toArray()]);
        }

        if (Auth::user()) {
            $canAnalyse = (bool) array_get($repos->get(Auth::user()), $repo->id);
        } else {
            $canAnalyse = false;
        }

        return View::make('repo')->withRepo($repo)->withAnalysis($analyses)->withCanAnalyse($canAnalyse)->withBranches($branches->get($repo));
    }

    /**
     * Handles the request to analyse a repo.
     *
     * @param \StyleCI\StyleCI\Models\Repo  $repo
     * @param \StyleCI\StyleCI\GitHub\Repos $repos
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\Http\Response
     */
    public function handleAnalyse(Repo $repo, Repos $repos)
    {
        if (!array_get($repos->get(Auth::user()), $repo->id)) {
            throw new HttpException(403);
        }

        $this->dispatch(new AnalyseBranchCommand($repo, Request::get('branch')));

        if (Request::ajax()) {
            return new JsonResponse(['queued' => true]);
        }

        return Redirect::route('repo_path', $repo->id);
    }
}
