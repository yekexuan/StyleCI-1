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
use StyleCI\StyleCI\Commands\Analysis\AnalyzeCommitCommand;
use StyleCI\StyleCI\Jobs\Analysis\RunAnalysisJob;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the analyze commit command handler.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalyzeCommitCommandHandler
{
    use DispatchesJobs;

    /**
     * Handle the analyze commit command.
     *
     * @param \StyleCI\StyleCI\Commands\Analysis\AnalyzeCommitCommand $command
     *
     * @return void
     */
    public function handle(AnalyzeCommitCommand $command)
    {
        $analysis = Analysis::create([
            'repo_id' => $command->repo->id,
            'branch'  => $command->branch,
            'commit'  => $command->commit,
            'message' => $command->message,
            'status'  => Analysis::PENDING,
            'hidden'  => false,
        ]);

        $this->dispatch(new RunAnalysisJob($analysis));
    }
}
