<?php

namespace Huangdijia\Mxtong;

use Huangdijia\Mxtong\Console\InfoCommand;
use Huangdijia\Mxtong\Console\SendCommand;
use Illuminate\Support\ServiceProvider;

class MxtongServiceProvider extends ServiceProvider
{
    protected $defer = true;

    protected $commands = [
        SendCommand::class,
        // InfoCommand::class,
    ];

    public function boot()
    {
        $this->bootConfig();

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/config.php' => config_path('mxtong.php')]);
        }
    }

    public function register()
    {
        $this->app->singleton(Mxtong::class, function () {
            return new Mxtong(config('mxtong'));
        });

        $this->app->alias(Mxtong::class, 'sms.mxtong');

        $this->commands($this->commands);
    }

    public function bootConfig()
    {
        $path = __DIR__ . '/../config/config.php';

        $this->mergeConfigFrom($path, 'mxtong');
    }

    public function provides()
    {
        return [
            Mxtong::class,
            'sms.mxtong',
        ];
    }
}
