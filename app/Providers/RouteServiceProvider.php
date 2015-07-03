<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use StyleCI\StyleCI\Models\Analysis;
use StyleCI\StyleCI\Models\Repo;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vinkla\Hashids\Facades\Hashids;

/**
 * This is the route service provider class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'StyleCI\StyleCI\Http\Controllers';

    /**
     * Define the route model bindings, pattern filters, etc.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->bind('analysis', function ($value) {
            $decoded = Hashids::connection('analyses')->decode($value);

            if (isset($decoded[0]) && $analysis = Analysis::find($decoded[0])) {
                return $analysis;
            }

            throw new NotFoundHttpException('Analysis not found.');
        });

        $router->bind('repo', function ($value) {
            if ($repo = Repo::find($value)) {
                return $repo;
            }

            throw new NotFoundHttpException('Repo not found.');
        });
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {
            foreach (glob(app_path('Http//Routes').'/*.php') as $file) {
                $this->app->make('StyleCI\\StyleCI\\Http\\Routes\\'.basename($file, '.php'))->map($router);
            }
        });
    }
}
