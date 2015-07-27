<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Providers;

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use StyleCI\StyleCI\Http\Middleware\RepoProtection;
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

            if (isset($decoded[0]) && is_numeric($decoded[0]) && $analysis = Analysis::find($decoded[0])) {
                return $analysis;
            }

            throw new NotFoundHttpException('Analysis not found.');
        });

        $router->bind('repo', function ($value) {
            if (is_numeric($value) && $repo = Repo::find($value)) {
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
                $routes = $this->app->make('StyleCI\\StyleCI\\Http\\Routes\\'.basename($file, '.php'));
                if ($routes::$browser) {
                    $this->mapForBrowser($router, $routes);
                } else {
                    $this->mapOtherwise($router, $routes);
                }
            }
        });
    }

    /**
     * Wrap the routes in the browser specific middleware.
     *
     * @param \Illuminate\Routing\Router $router
     * @param object                     $router
     *
     * @return void
     */
    protected function mapForBrowser(Router $router, $routes)
    {
        $router->group(['middleware' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            RepoProtection::class,
        ]], function (Router $router) use ($routes) {
            $routes->map($router);
        });
    }

    /**
     * Wrap the routes in the basic middleware.
     *
     * @param \Illuminate\Routing\Router $router
     * @param object                     $router
     *
     * @return void
     */
    protected function mapOtherwise(Router $router, $routes)
    {
        $router->group(['middleware' => [
            RepoProtection::class,
        ]], function (Router $router) use ($routes) {
            $routes->map($router);
        });
    }
}
