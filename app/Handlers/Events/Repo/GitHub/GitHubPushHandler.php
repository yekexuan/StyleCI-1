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
use StyleCI\StyleCI\Commands\Analysis\AnalyzeCommitCommand;
use StyleCI\StyleCI\Events\Repo\GitHub\GitHubPushEvent;

/**
 * This is the github push handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GitHubPushHandler
{
    use DispatchesJobs;

    /**
     * Handle the github push event.
     *
     * @param \StyleCI\StyleCI\Events\Repo\GitHub\GitHubPushEvent $event
     *
     * @return void
     */
    public function handle(GitHubPushEvent $event)
    {
        $data = $event->data;

        if (!$this->shouldAnalyze($data)) {
            return;
        }

        $branch = substr($data['ref'], 11);
        $commit = $data['head_commit']['id'];
        $message = Str::commit($data['head_commit']['message']);

        $this->dispatch(new AnalyzeCommitCommand($event->repo, $branch, $commit, $message));
    }

    /**
     * Should we analyze the commit.
     *
     * @param array $data
     *
     * @return bool
     */
    protected function shouldAnalyze(array $data)
    {
        return $data['head_commit'] && substr($data['ref'], 0, 11) === 'refs/heads/' && strpos($data['ref'], 'gh-pages') === false;
    }
}
