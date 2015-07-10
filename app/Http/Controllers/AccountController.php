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

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use StyleCI\StyleCI\Commands\Repo\DisableRepoCommand;
use StyleCI\StyleCI\Commands\Repo\EnableRepoCommand;
use StyleCI\StyleCI\Commands\User\DeleteAccountCommand;
use StyleCI\StyleCI\GitHub\Repos;
use StyleCI\StyleCI\Http\Middleware\Authenticate;
use StyleCI\StyleCI\Models\Repo;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * This is the account controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AccountController extends Controller
{
    use DispatchesJobs;

    /**
     * The github repos instance.
     *
     * @var \StyleCI\StyleCI\GitHub\Repos
     */
    protected $repos;

    /**
     * Create a new account controller instance.
     *
     * @param \StyleCI\StyleCI\GitHub\Repos $repos
     *
     * @return void
     */
    public function __construct(Repos $repos)
    {
        $this->repos = $repos;

        $this->middleware(Authenticate::class);
    }

    /**
     * Show the user's account information.
     *
     * @return \Illuminate\View\View
     */
    public function handleShow()
    {
        return View::make('account');
    }

    /**
     * Show the user's repositories.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function handleListRepos()
    {
        $repos = $this->repos->get(Auth::user(), true);

        if (Request::ajax()) {
            return new JsonResponse(['data' => $repos]);
        }

        return View::make('account')->withRepos($repos);
    }

    /**
     * Sync the user's repositories.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleSync()
    {
        $this->repos->flush(Auth::user());

        if (Request::ajax()) {
            return new JsonResponse(['flushed' => true]);
        }

        return Redirect::route('account_path');
    }

    /**
     * Enable StyleCI for a repo.
     *
     * @param int $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\Http\Response
     */
    public function handleEnable($id)
    {
        $repo = array_get($this->repos->get(Auth::user(), true), $id);

        if (!$repo) {
            throw new HttpException(403);
        }

        $this->dispatch(new EnableRepoCommand($id, $repo['name'], $repo['default_branch'], Auth::user()));

        if (Request::ajax()) {
            return new JsonResponse(['enabled' => true]);
        }

        return Redirect::route('account_path');
    }

    /**
     * Disable StyleCI for a repo.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\Http\Response
     */
    public function handleDisable(Repo $repo)
    {
        if (!array_get($this->repos->get(Auth::user(), true), $repo->id)) {
            throw new HttpException(403);
        }

        $this->dispatch(new DisableRepoCommand($repo));

        if (Request::ajax()) {
            return new JsonResponse(['enabled' => false]);
        }

        return Redirect::route('account_path');
    }

    /**
     * Delete the user's account and all their repos.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleDelete()
    {
        $this->dispatch(new DeleteAccountCommand(Auth::user()));

        return Redirect::route('home')->with('success', 'Your account has been successfully deleted!');
    }
}
