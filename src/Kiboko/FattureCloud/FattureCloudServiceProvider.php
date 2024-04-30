<?php

namespace Kiboko\FattureCloud;

use Illuminate\Support\ServiceProvider;

class FattureCloudServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        
        $this->app->bind('FattureCloud', function ($app)
        {
            return new FattureCloud();
        });
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('FattureCloud');
    }
}