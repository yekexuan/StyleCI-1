<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Commands\Repo;

use StyleCI\StyleCI\Commands\Analysis\DeleteAnalysisCommand;
use StyleCI\StyleCI\Commands\Repo\DisableRepoCommand;
use StyleCI\StyleCI\Events\Repo\RepoWasDisabledEvent;

/**
 * This is the disable repo command handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class DisableRepoCommandHandler
{
    /**
     * Handle the disable repo command.
     *
     * @param \StyleCI\StyleCI\Commands\Repo\DisableRepoCommand $command
     *
     * @return void
     */
    public function handle(DisableRepoCommand $command)
    {
        $repo = $command->repo;

        foreach ($repo->analyses as $analysis) {
            dispatch(new DeleteAnalysisCommand($analysis));
        }

        event(new RepoWasDisabledEvent($repo));

        $repo->delete();
    }
}
