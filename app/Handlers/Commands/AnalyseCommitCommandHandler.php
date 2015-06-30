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
use StyleCI\StyleCI\Commands\AnalyseCommitCommand;
use StyleCI\StyleCI\Commands\RunAnalysisCommand;
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
     * @param \StyleCI\StyleCI\Commands\AnalyseCommitCommand $command
     *
     * @return void
     */
    public function handle(AnalyseCommitCommand $command)
    {
        $analysis = Analysis::create([
            'repo_id' => $command->repo,
            'branch'  => $command->branch,
            'commit'  => $command->commit,
            'message' => $command->message,
        ]);

        $this->dispatch(new RunAnalysisCommand($analysis));
    }
}
