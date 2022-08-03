<?php

namespace Freis\NovaGridLayout;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Freis\NovaGridLayout\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(NovaRequest $novaRequest)
    {
        Nova::serving(function (ServingNova $event) use ($novaRequest) {
            $this->app->booted(function () {
                $this->routes();
            });

            Field::macro('withSize', function (string $size = 'w-full') use ($novaRequest) {
                return $this->withMeta(['size' => $size]);
            });

            Field::macro('size', function ($size = 'w-full') use ($novaRequest) {
                $this->withSize($size);
                return $this;
            });
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Nova::router(['nova', Authenticate::class, Authorize::class], 'nova-grid-layout')
            ->group(__DIR__.'/../routes/inertia.php');

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/nova-grid-layout')
            ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
