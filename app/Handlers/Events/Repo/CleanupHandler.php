<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Handlers\Events\Repo;

use Illuminate\Contracts\Foundation\Application;
use StyleCI\StyleCI\Events\Analysis\AnalysisHasCompletedEvent;

/**
 * This is the cleanup handler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CleanupHandler
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Create a new cleanup handler instance.
     *
     * We're injection an application instance here so we can defer resolving
     * the actual dependencies until we've actually decided if we should
     * actually perform garbage collection on this run.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle the analysis has completed event.
     *
     * We have a 1 in 16 chance of performing a cleanup.
     *
     * @param \StyleCI\StyleCI\Events\Analysis\AnalysisHasCompletedEvent $event
     *
     * @return void
     */
    public function handle(AnalysisHasCompletedEvent $event)
    {
        if (random_int(0, 15) > 0) {
            return;
        }

        $path = $this->app->make('path.storage');
        $factory = $this->app->make('git.factory');

        $factory->gc("{$path}/repos", 14);
    }
}
