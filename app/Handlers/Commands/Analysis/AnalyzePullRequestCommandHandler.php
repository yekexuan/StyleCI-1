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

use StyleCI\StyleCI\Commands\Analysis\AnalyzePullRequestCommand;
use StyleCI\StyleCI\Jobs\Analysis\RunAnalysisJob;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the analyze pull request command handler.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AnalyzePullRequestCommandHandler
{
    /**
     * Handle the analyze pull request command.
     *
     * @param \StyleCI\StyleCI\Commands\Analysis\AnalyzePullRequestCommand $command
     *
     * @return void
     */
    public function handle(AnalyzePullRequestCommand $command)
    {
        $analysis = Analysis::create([
            'repo_id' => $command->repo->id,
            'pr'      => $command->pr,
            'commit'  => $command->commit,
            'message' => $command->message,
            'status'  => Analysis::PENDING,
            'hidden'  => false,
        ]);

        dispatch(new RunAnalysisJob($analysis));
    }
}
