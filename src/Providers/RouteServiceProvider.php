<?php

namespace TypiCMS\Modules\Categories\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Categories\Repositories\CategoryInterface;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Categories\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);
        if (Request::segment(1) != 'admin' && Request::segment(1) != 'api') {
            $router->bind('category', function ($slug) {
                $repository = app(CategoryInterface::class);

                return $repository->bySlug($slug);
            });
        }
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
            /*
             * Admin routes
             */
            $router->get('admin/categories', ['as' => 'admin.categories.index', 'uses' => 'AdminController@index']);
            $router->get('admin/categories/create', ['as' => 'admin.categories.create', 'uses' => 'AdminController@create']);
            $router->get('admin/categories/{category}/edit', ['as' => 'admin.categories.edit', 'uses' => 'AdminController@edit']);
            $router->post('admin/categories', ['as' => 'admin.categories.store', 'uses' => 'AdminController@store']);
            $router->put('admin/categories/{category}', ['as' => 'admin.categories.update', 'uses' => 'AdminController@update']);
            $router->post('admin/categories/sort', ['as' => 'admin.categories.sort', 'uses' => 'AdminController@sort']);

            /*
             * API routes
             */
            $router->get('api/categories', ['as' => 'api.categories.index', 'uses' => 'ApiController@index']);
            $router->put('api/categories/{category}', ['as' => 'api.categories.update', 'uses' => 'ApiController@update']);
            $router->delete('api/categories/{category}', ['as' => 'api.categories.destroy', 'uses' => 'ApiController@destroy']);
        });
    }
}
