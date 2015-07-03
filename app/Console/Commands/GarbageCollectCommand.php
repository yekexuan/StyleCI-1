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

/**
 * This is the garbage collect command class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GarbageCollectCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'styleci:gc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all cached repos not used in the last 2 weeks';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Running the garbage collector.');

        $path = $this->laravel['path.storage'];

        $factory = $this->laravel['git.factory'];

        $count = $factory->gc("{$path}/repos", 14) + $factory->gc("{$path}/fixers", 28);

        $this->info("Removed $count old repos.");
    }
}
