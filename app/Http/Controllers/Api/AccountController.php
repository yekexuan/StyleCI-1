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
use StyleCI\StyleCI\Commands\Repo\DisableRepoCommand;
use StyleCI\StyleCI\Commands\Repo\EnableRepoCommand;
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
     * Create a new account controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    /**
     * Show the user's repositories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleListRepos()
    {
        $repos = app(Repos::class)->get(Auth::user(), true);

        return new JsonResponse(['data' => $repos]);
    }

    /**
     * Sync the user's repositories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleSync()
    {
        app(Repos::class)->flush(Auth::user());

        return new JsonResponse(['flushed' => true]);
    }

    /**
     * Enable StyleCI for a repo.
     *
     * @param int $id
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleEnable($id)
    {
        $repo = array_get(app(Repos::class)->get(Auth::user(), true), $id);

        if (!$repo) {
            throw new HttpException(403);
        }

        $this->dispatch(new EnableRepoCommand($id, $repo['name'], $repo['default_branch'], Auth::user()));

        return new JsonResponse(['enabled' => true]);
    }

    /**
     * Disable StyleCI for a repo.
     *
     * @param \StyleCI\StyleCI\Models\Repo $repo
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleDisable(Repo $repo)
    {
        if (!array_get(app(Repos::class)->get(Auth::user(), true), $repo->id)) {
            throw new HttpException(403);
        }

        $this->dispatch(new DisableRepoCommand($repo));

        return new JsonResponse(['enabled' => false]);
    }
}
