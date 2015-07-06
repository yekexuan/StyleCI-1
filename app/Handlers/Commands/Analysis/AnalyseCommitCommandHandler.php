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
use StyleCI\StyleCI\Commands\Analysis\AnalyseCommitCommand;
use StyleCI\StyleCI\Jobs\Analysis\RunAnalysisJob;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the analyse commit command handler.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalyseCommitCommandHandler
{
    use DispatchesJobs;

    /**
     * Handle the analyse commit command.
     *
     * @param \StyleCI\StyleCI\Commands\Analysis\AnalyseCommitCommand $command
     *
     * @return void
     */
    public function handle(AnalyseCommitCommand $command)
    {
        $analysis = Analysis::create([
            'repo_id' => $command->repo->id,
            'branch'  => $command->branch,
            'commit'  => $command->commit,
            'message' => $command->message,
            'status'  => 0,
        ]);

        $this->dispatch(new RunAnalysisJob($analysis));
    }
}
