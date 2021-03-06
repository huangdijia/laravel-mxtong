<?php

namespace Huangdijia\Mxtong\Console;

use Huangdijia\Mxtong\MxtongServiceProvider;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature   = 'mxtong:install';
    protected $description = 'Install config.';

    public function handle()
    {
        $this->info('Installing Package...');

        $this->info('Publishing configuration...');

        $this->call('vendor:publish', [
            '--provider' => MxtongServiceProvider::class,
            '--tag'      => "config",
        ]);

        $this->info('Installed Package');
    }
}
