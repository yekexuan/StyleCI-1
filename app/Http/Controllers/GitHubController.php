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
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use StyleCI\StyleCI\Http\Middleware\BodySize;
use StyleCI\StyleCI\Http\Middleware\EventHeader;
use StyleCI\StyleCI\Models\Repo;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * This is the github controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GitHubController extends Controller
{
    /**
     * Create a new github controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(BodySize::class);
        $this->middleware(EventHeader::class);
    }

    /**
     * Handles the request made to StyleCI by the GitHub API.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle()
    {
        $class = 'StyleCI\StyleCI\Events\Repo\GitHub\GitHub'.ucfirst(camel_case(Request::header('X-GitHub-Event'))).'Event';

        if (!class_exists($class)) {
            throw new BadRequestHttpException('Event not supported.');
        }

        $data = Request::input();
        $repo = Repo::find($data['repository']['id']);

        if (!$repo) {
            throw new BadRequestHttpException('Request integrity validation failed.');
        }

        list($algo, $sig) = explode('=', Request::header('X-Hub-Signature'));

        $hash = hash_hmac($algo, Request::getContent(), $repo->token);

        if (!Str::equals($hash, $sig)) {
            throw new BadRequestHttpException('Request integrity validation failed.');
        }

        event(new $class($repo, $data));

        return new JsonResponse(['message' => 'Event successfully received.']);
    }
}
