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
use StyleCI\StyleCI\Commands\AnalysePullRequestCommand;
use StyleCI\StyleCI\Commands\RunAnalysisCommand;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the analyse pull request command handler.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalysePullRequestCommandHandler
{
    use DispatchesJobs;

    /**
     * Handle the analyse pull request command.
     *
     * @param \StyleCI\StyleCI\Commands\AnalysePullRequestCommand $command
     *
     * @return void
     */
    public function handle(AnalysePullRequestCommand $command)
    {
        $analysis = Analysis::create([
            'repo_id' => $command->repo->id,
            'pr'      => $command->pr,
            'commit'  => $command->commit,
            'message' => $command->message,
        ]);

        $this->dispatch(new RunAnalysisCommand($analysis));
    }
}
