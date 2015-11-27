<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Console;

use Illuminate\Console\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * This is the console kernel class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Kernel extends ConsoleKernel
{
    /**
     * Get the artisan application instance.
     *
     * @return \Illuminate\Console\Application
     */
    protected function getArtisan()
    {
        if (!$this->artisan) {
            $this->artisan = new Application($this->app, $this->events, $this->app->version());

            $commands = [];

            foreach (glob(app_path('Console//Commands').'/*.php') as $file) {
                $commands[] = 'StyleCI\\StyleCI\\Console\\Commands\\'.basename($file, '.php');
            }

            $this->artisan->resolveCommands($commands);
        }

        return $this->artisan;
    }
}
