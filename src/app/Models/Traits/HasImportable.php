<?php

namespace sOne\Core\app\Models\Traits;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

trait HasImportable
{
    /**
     * Импорт данных из файла.
     *
     * @param Request $request
     * @return void
     */
    public static function importData(Request $request): void
    {
        $importer = new self->importer();
        Excel::import($importer, $request->file('import_file'));
    }

    /**
     * Получить класс импортера.
     *
     * @return string
     */
    public function importer(): string
    {
        return \sOne\Core\app\Imports\{class_basename($this)}Import::class;
    }
}
