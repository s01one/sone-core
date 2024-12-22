<?php

namespace sOne\Core\app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    protected $signature = 'sone:core:install';
    protected $description = 'Install the sOne Core package';

    public function handle()
    {
        $this->info('Installing sOne Core package...');

        $this->info('Publishing configuration and views...');
        Artisan::call('vendor:publish', [
            '--provider' => 'sOne\Core\sOneCoreServiceProvider',
            '--tag' => ['config', 'views'],
            '--force' => true,
        ]);

        $this->info('Building and publishing assets...');
        Artisan::call('install:api');
        Artisan::call('sone:core:build');
        Artisan::call('ziggy:generate');
        Artisan::call('optimize:clear');

        $this->info('sOne Core installed successfully.');
    }
}
