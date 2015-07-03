<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use StyleCI\StyleCI\Commands\Analysis\CleanupAnalysisCommand;
use StyleCI\StyleCI\Models\Analysis;

/**
 * This is the cleanup command class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CleanupCommand extends Command
{
    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'styleci:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marks all timed out analyses as errored';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        foreach (Analysis::old()->pending()->orderBy('created_at', 'desc')->get() as $analysis) {
            $this->info("Cleaning up analysis {$analysis->id}.");
            $this->dispatch(new CleanupAnalysisCommand($analysis));
        }
    }
}
