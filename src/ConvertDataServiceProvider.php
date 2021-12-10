<?php

namespace Amrdevac\Datatojson;

use Illuminate\Support\ServiceProvider;

class ConvertDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ConvertDataCommand::class,
            ]);
        }
    }
}
