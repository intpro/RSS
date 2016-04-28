<?php

namespace Interpro\RSS;

use Illuminate\Support\ServiceProvider;
use Illuminate\Bus\Dispatcher;

class RSSServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Dispatcher $dispatcher)
    {
        //Publishes package config file to applications config folder
        $this->publishes([__DIR__.'/Laravel/config/rss.php' => config_path('rss.php')]);

        $dispatcher->maps([
            'Interpro\RSS\Concept\Command\FetchRSSCommand' => 'Interpro\RSS\Laravel\Handle\FetchRSSCommandHandler@handle',
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Interpro\RSS\Laravel\Http\RSSController');

        include __DIR__ . '/Laravel/Http/routes.php';
    }

}

