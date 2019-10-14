<?php

namespace LaraFlux;

use InfluxDB\Client;
use InfluxDB\Driver\UDP;
use LaraFlux\Facades\LaraFlux;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('LaraFlux', function($app) {
            $client = new Client(
                config('lara-flux.host'),
                config('lara-flux.port'),
                config('lara-flux.username'),
                config('lara-flux.password'),
                config('lara-flux.ssl'),
                config('lara-flux.verify_ssl'),
                config('lara-flux.timeout'),
                config('lara-flux.connect_timeout')
            );

            // UDP can not write currently
//            if (config('lara-flux.udp.enabled')) {
//                $client->setDriver(new UDP(
//                    $client->getHost(),
//                    config('lara-flux.udp.port')
//                ));
//            }

            return $client;
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/lara-flux.php' => config_path('lara-flux.php'),
        ], 'lara-flux-config');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            LaraFlux::class,
        ];
    }
}
