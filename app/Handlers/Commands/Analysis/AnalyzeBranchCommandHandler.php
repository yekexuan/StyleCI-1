<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Commands\Analysis;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;
use StyleCI\StyleCI\Commands\Analysis\AnalyzeBranchCommand;
use StyleCI\StyleCI\GitHub\Branches;
use StyleCI\StyleCI\GitHub\Commits;
use StyleCI\StyleCI\Jobs\Analysis\RunAnalysisJob;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the analyze branch command handler.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalyzeBranchCommandHandler
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
     * Create a new analyze branch command handler instance.
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
     * Handle the analyze branch command.
     *
     * @param \StyleCI\StyleCI\Commands\Analysis\AnalyzeBranchCommand $command
     *
     * @return void
     */
    public function handle(AnalyzeBranchCommand $command)
    {
        $repo = $command->repo;
        $branch = $command->branch;
        $commit = $this->branches->getCommit($repo, $branch);
        $message = Str::commit($this->commits->get($repo, $commit)['commit']['message']);

        $analysis = Analysis::create([
            'repo_id' => $repo->id,
            'branch'  => $branch,
            'commit'  => $commit,
            'message' => $message,
            'status'  => Analysis::PENDING,
            'hidden'  => false,
        ]);

        $this->dispatch(new RunAnalysisJob($analysis));
    }
}
