<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;
use StyleCI\StyleCI\Commands\AnalyseBranchCommand;
use StyleCI\StyleCI\Commands\RunAnalysisCommand;
use StyleCI\StyleCI\GitHub\Branches;
use StyleCI\StyleCI\GitHub\Commits;
use StyleCI\StyleCI\Models\Analysis;
use StyleCI\StyleCI\Models\Repo;

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
     * @param \StyleCI\StyleCI\Commands\AnalyseBranchCommand $command
     *
     * @return void
     */
    public function handle(AnalyseBranchCommand $command)
    {
        $repo = Repo::findOrFail($command->repo);
        $branch = $command->branch;
        $commit = $this->branches->getCommit($repo, $branch);
        $message = substr($this->commits->get($repo, $commit)['commit']['message'], 0, 128);

        $analysis = Analysis::create([
            'repo_id'  => $command->repo,
            'branch'  => $branch,
            'commit'  => $commit,
            'message' => $message,
        ]);

        $this->dispatch(new RunAnalysisCommand($analysis));
    }
}
