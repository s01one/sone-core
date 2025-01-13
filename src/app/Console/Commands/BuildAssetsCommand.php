<?php

namespace sOne\Core\app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BuildAssetsCommand extends Command
{
    protected $signature = 'sone:core:build';
    protected $description = 'Build and publish assets for sone-core package';

    public function handle()
    {
        $this->info("Building assets...");

        $packagePath = base_path('vendor/sonecms/sone-core');

        if (!is_dir($packagePath)) {
            $this->error("Package directory not found: {$packagePath}");
            return;
        }

        $this->info("Running npm install...");
        $process = Process::fromShellCommandline('npm install');
        $process->setWorkingDirectory($packagePath);
        $process->setTimeout(300);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });

        if (!$process->isSuccessful()) {
            $this->error("Error during npm install.");
            $this->error($process->getErrorOutput());
            return;
        }

        $this->info("Running npm run build...");
        $process = Process::fromShellCommandline('npm run build');
        $process->setWorkingDirectory($packagePath);
        $process->setTimeout(600);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });

        if (!$process->isSuccessful()) {
            $this->error("Error during npm run build.");
            $this->error($process->getErrorOutput());
            return;
        }

        $this->info("Publishing assets...");
        Artisan::call('vendor:publish', [
            '--tag' => 'public',
            '--provider' => "sOne\Core\sOneCoreServiceProvider",
            '--force' => true,
        ]);

        $this->info("Assets built and published successfully.");
    }
}
