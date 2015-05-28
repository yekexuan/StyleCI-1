<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Providers;

use Illuminate\Support\ServiceProvider;
use StyleCI\StyleCI\Composers\CurrentUserComposer;
use StyleCI\StyleCI\Composers\CurrentUrlComposer;

/**
 * This is the view composer service provider class.
 *
 * @author Joseph Cohen <joseph.cohen@dinkbit.com>
 */
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->view->composer('*', CurrentUserComposer::class);
        $this->app->view->composer('*', CurrentUrlComposer::class);
    }
}
