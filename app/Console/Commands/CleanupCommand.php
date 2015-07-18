<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use StyleCI\StyleCI\Jobs\Analysis\CleanupAnalysisJob;
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
    protected $description = 'Marks all timed out analyses as errored and delete old hidden analyses';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        touch($this->laravel->storagePath().'/framework/down');

        foreach (Analysis::old()->pending()->orderBy('created_at', 'desc')->get() as $analysis) {
            $this->info("Cleaning up analysis {$analysis->id}.");
            $this->dispatch(new CleanupAnalysisJob($analysis));
        }

        $storage = $this->laravel['storage.connection'];

        foreach (Analysis::hidden()->veryOld()->get() as $analysis) {
            if ($analysis->status === 3 || $analysis->status === 5) {
                $storage->delete($analysis->id);
            }
            $analysis->delete();
        }

        @unlink($this->laravel->storagePath().'/framework/down');
    }
}
