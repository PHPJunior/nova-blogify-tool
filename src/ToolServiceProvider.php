<?php

namespace Mattmangoni\NovaBlogifyTool;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Mattmangoni\NovaBlogifyTool\Bootstrap\Blogify;
use Mattmangoni\NovaBlogifyTool\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova-blogify-tool');

        $this->publishes([
            $this->configPath() => config_path('nova-blogify-tool.php')
        ],'nova-blogify-tool-config');

        $this->app->booted(function () {
            $this->routes();

            Blogify::injectToolResources();
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

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/nova-blogify-tool')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), 'nova-blogify-tool');
    }

    /**
     * @return string
     */
    protected function configPath()
    {
        return __DIR__.'/../config/nova-blogify-tool.php';
    }
}
