<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events\Repo\GitHub;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;
use StyleCI\StyleCI\Commands\Analysis\AnalysePullRequestCommand;
use StyleCI\StyleCI\Events\Repo\GitHub\GitHubPullRequestEvent;

/**
 * This is the github pull request handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GitHubPullRequestHandler
{
    use DispatchesJobs;

    /**
     * Handle the github pull request event.
     *
     * @param \StyleCI\StyleCI\Events\Repo\GitHub\GitHubPullRequestEvent $event
     *
     * @return void
     */
    public function handle(GitHubPullRequestEvent $event)
    {
        $data = $event->data;

        if (!$this->isValidBranch($data) || !$this->shouldAnalyse($data)) {
            return;
        }

        $pr = $data['number'];
        $commit = $data['pull_request']['head']['sha'];
        $message = Str::commit('Pull Request: '.$data['pull_request']['title']);

        $this->dispatch(new AnalysePullRequestCommand($event->repo, $pr, $commit, $message));
    }

    /**
     * Was the PR sent to a valid branch.
     *
     * @param array $data
     *
     * @return bool
     */
    protected function isValidBranch(array $data)
    {
        return strpos($data['pull_request']['base']['ref'], 'gh-pages') === false;
    }

    /**
     * Should we analyse the PR.
     *
     * @param array $data
     *
     * @return bool
     */
    protected function shouldAnalyse(array $data)
    {
        return (in_array($data['action'], ['opened', 'synchronize'], true) && !$this->isOriginRepo($data)) || $data['action'] === 'reopened';
    }

    /**
     * Was the PR sent from the origin repo.
     *
     * @param array $data
     *
     * @return bool
     */
    protected function isOriginRepo(array $data)
    {
        return $data['pull_request']['head']['repo']['full_name'] === $data['pull_request']['base']['repo']['full_name'];
    }
}
