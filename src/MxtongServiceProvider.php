<?php

namespace Huangdijia\Mxtong;

use Illuminate\Support\ServiceProvider;

class MxtongServiceProvider extends ServiceProvider
{
    // protected $defer = true;

    protected $commands = [
        Console\InstallCommand::class,
        Console\SendCommand::class,
    ];

    public function boot()
    {
        $this->bootConfig();

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/mxtong.php' => $this->app->basePath('config/mxtong.php')], 'config');
        }
    }

    public function register()
    {
        $this->app->singleton(Mxtong::class, function () {
            return new Mxtong($this->app['config']->get('mxtong'));
        });

        $this->app->alias(Mxtong::class, 'sms.mxtong');

        $this->commands($this->commands);
    }

    public function bootConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/mxtong.php', 'mxtong');
    }

    public function provides()
    {
        return [
            Mxtong::class,
            'sms.mxtong',
        ];
    }
}
