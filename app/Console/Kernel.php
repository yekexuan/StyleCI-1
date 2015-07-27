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

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use StyleCI\StyleCI\Console\Commands\RepoCommand;
use StyleCI\StyleCI\Console\Commands\UserCommand;

/**
 * This is the console kernel class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var string[]
     */
    protected $commands = [
        RepoCommand::class,
        UserCommand::class,
    ];
}
