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

use StyleCI\StyleCI\Commands\CleanupAnalysisCommand;
use StyleCI\StyleCI\Events\AnalysisHasCompletedEvent;

/**
 * This is the cleanup analysis command handler.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CleanupAnalysisCommandHandler
{
    /**
     * Handle the cleanup analysis command.
     *
     * @param \StyleCI\StyleCI\Commands\CleanupAnalysisCommand $command
     *
     * @return void
     */
    public function handle(CleanupAnalysisCommand $command)
    {
        $analysis = $command->analysis;

        $analysis->status = 6;
        $analysis->save();

        event(new AnalysisHasCompletedEvent($analysis));
    }
}
