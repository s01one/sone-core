<?php

namespace sOne\Core\app\Models\Traits;

use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

trait HasExportable
{
    /**
     * Экспорт данных в файл.
     *
     * @return BinaryFileResponse
     */
    public static function exportData(): BinaryFileResponse
    {
        $exporter = new self->exporter();
        return Excel::download($exporter, class_basename(self) . '_export.xlsx');
    }

    /**
     * Получить класс экспортера.
     *
     * @return string
     */
    public function exporter(): string
    {
        return \sOne\Core\app\Exports\{class_basename($this)}Export::class;
    }
}
