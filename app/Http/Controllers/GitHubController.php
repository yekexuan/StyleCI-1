<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use StyleCI\StyleCI\Commands\AnalyseCommitCommand;
use StyleCI\StyleCI\Commands\AnalysePullRequestCommand;

/**
 * This is the github controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GitHubController extends AbstractController
{
    /**
     * Create a new github controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(['except' => ['handle']]);
    }

    /**
     * Handles the request made to StyleCI by the GitHub API.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request)
    {
        switch ($request->header('X-GitHub-Event')) {
            case 'push':
                return $this->handlePush($request->input());
            case 'pull_request':
                return $this->handlePullRequest($request->input());
            case 'ping':
                return $this->handlePing();
            default:
                return $this->handleOther();
        }
    }

    /**
     * Handle pushing of a branch.
     *
     * @param array $input
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handlePush(array $input)
    {
        if ($input['head_commit'] && substr($input['ref'], 0, 11) === 'refs/heads/' && strpos($input['ref'], 'gh-pages') === false) {
            $repo = $input['repository']['id'];
            $branch = substr($input['ref'], 11);
            $commit = $input['head_commit']['id'];
            $message = substr(strtok(strtok($input['head_commit']['message'], "\n"), "\r"), 0, 128);

            $this->dispatch(new AnalyseCommitCommand($repo, $branch, $commit, $message));

            return new JsonResponse(['message' => 'StyleCI has successfully scheduled the analysis of this event.'], 202, [], JSON_PRETTY_PRINT);
        }

        return new JsonResponse(['message' => 'StyleCI has determined that no action is required in this case.'], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Handle opening of a pull request.
     *
     * Here's we analysing all new commits pushed a pull request ONLY from
     * repos that are not the original. Commits pushed to the original will be
     * analaysed via the push hook instead.
     *
     * @param array $input
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handlePullRequest(array $input)
    {
        if (($input['action'] === 'opened' || $input['action'] === 'reopened' || $input['action'] === 'synchronize') && $input['pull_request']['head']['repo']['full_name'] !== $input['pull_request']['base']['repo']['full_name'] && strpos($input['pull_request']['head']['ref'], 'gh-pages') === false) {
            $repo = $input['pull_request']['base']['repo']['id'];
            $pr = $input['number'];
            $commit = $input['pull_request']['head']['sha'];
            $message = substr('Pull Request: '.strtok(strtok($input['pull_request']['title'], "\n"), "\r"), 0, 128);

            $this->dispatch(new AnalysePullRequestCommand($repo, $pr, $commit, $message));

            return new JsonResponse(['message' => 'StyleCI has successfully scheduled the analysis of this event.'], 202, [], JSON_PRETTY_PRINT);
        }

        return new JsonResponse(['message' => 'StyleCI has determined that no action is required in this case.'], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Handle GitHub setup ping.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handlePing()
    {
        return new JsonResponse(['message' => 'StyleCI successfully received your ping.'], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Handle any other kind of input.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleOther()
    {
        return new JsonResponse(['message' => 'StyleCI does not support this type of event.'], 400, [], JSON_PRETTY_PRINT);
    }
}
