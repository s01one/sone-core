<?php

namespace sOne\Core\app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class BuildAssetsCommand extends Command
{
    protected $signature = 'sone:core:build';
    protected $description = 'Build and publish assets for sone-core package';

    public function handle()
    {
        $packagePath = base_path('vendor/sonecms/sone-core');
        $this->info($packagePath);
        $this->info("Переходим в директорию: $packagePath");
        chdir($packagePath);

        $this->info("Устанавливаем npm зависимости...");
        exec('npm install', $output, $returnVar);
        if ($returnVar !== 0) {
            $this->error("Ошибка при установке npm зависимостей.");
            return;
        }

        $this->info("Запускаем сборку Vite...");
        exec('npm run build', $output, $returnVar);
        if ($returnVar !== 0) {
            $this->error("Ошибка при сборке Vite.");
            return;
        }

        chdir(base_path());

        $this->info("Публикуем ассеты...");
        Artisan::call('vendor:publish', [
            '--tag' => 'public',
            '--provider' => "sOne\Core\sOneCoreServiceProvider",
        ]);

        $this->info("Сборка и публикация ассетов завершены успешно.");
    }
}
