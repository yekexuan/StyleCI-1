<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Commands\Analysis;

use Illuminate\Foundation\Bus\DispatchesJobs;
use StyleCI\StyleCI\Commands\Analysis\AnalyseBranchCommand;
use StyleCI\StyleCI\GitHub\Branches;
use StyleCI\StyleCI\GitHub\Commits;
use StyleCI\StyleCI\Jobs\Analysis\RunAnalysisJob;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the analyse branch command handler.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalyseBranchCommandHandler
{
    use DispatchesJobs;

    /**
     * The branches instance.
     *
     * @var \StyleCI\StyleCI\GitHub\Branches
     */
    protected $branches;

    /**
     * The commits instance.
     *
     * @var \StyleCI\StyleCI\GitHub\Commits
     */
    protected $commits;

    /**
     * Create a new analyse branch command instance.
     *
     * @param \StyleCI\StyleCI\GitHub\Branches $branches
     * @param \StyleCI\StyleCI\GitHub\Commits  $commits
     *
     * @return void
     */
    public function __construct(Branches $branches, Commits $commits)
    {
        $this->branches = $branches;
        $this->commits = $commits;
    }

    /**
     * Handle the analyse branch command.
     *
     * @param \StyleCI\StyleCI\Commands\Analysis\AnalyseBranchCommand $command
     *
     * @return void
     */
    public function handle(AnalyseBranchCommand $command)
    {
        $repo = $command->repo;
        $branch = $command->branch;
        $commit = $this->branches->getCommit($repo, $branch);
        $message = substr($this->commits->get($repo, $commit)['commit']['message'], 0, 255);

        $analysis = Analysis::create([
            'repo_id' => $repo->id,
            'branch'  => $branch,
            'commit'  => $commit,
            'message' => $message,
            'status'  => 0,
        ]);

        $this->dispatch(new RunAnalysisJob($analysis));
    }
}
