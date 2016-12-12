<?php

namespace Rukhsar\PackMe;

use Illuminate\Support\ServiceProvider;

class PackMeServiceProvider extends ServiceProvider
{
    /**
     * Indicates if the loading of the provider is deferred
     * @var boolean
     */
    protected $defer = false;

    /**
     * The console commands to register
     * @var array
     */
    protected $commands = ['Rukhsar\PackMe\PackMeCommand'];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * Get the service provided by the provider
     * @return [type] [description]
     */
    public function provides()
    {
        return ['packmecommand'];
    }
}
