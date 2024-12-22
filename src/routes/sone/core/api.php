<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| sOne\Core\Api Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the sOne\Core\Api package.
|
*/
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'sOne\Core\app\Http\Controllers\Api',
    'prefix' => config('sone::sone.core.prefix_api', 'admin'),
    'middleware' => ['web'],
], function () {
    Route::apiResource('content', 'ContentController');
    Route::apiResource('context', 'ContextController');
    Route::apiResource('dashboard', 'DashboardController');
    Route::apiResource('languages', 'LanguagesController');
    Route::apiResource('licenses', 'LicensesController');
    Route::apiResource('modules', 'ModulesController');
    Route::apiResource('users/permissions', 'PermissionsController');
    Route::apiResource('users/roles', 'RolesController');
    Route::apiResource('settings', 'SettingsController');
    Route::apiResource('templates', 'TemplatesController');
    Route::apiResource('templates/settings', 'TemplatesSettingsController');
    Route::apiResource('users', 'UsersController');
    Route::apiResource('widgets', 'WidgetsController');

    Route::post('/{model}/bulk-delete', [sOne\Core\app\Http\Controllers\CrudController::class, 'bulkDelete'])->name('bulkDelete');
    Route::post('/{model}/import', [sOne\Core\app\Http\Controllers\CrudController::class, 'import'])->name('import');
    Route::get('/{model}/export', [sOne\Core\app\Http\Controllers\CrudController::class, 'export'])->name('export');

    Route::get('/models', [sOne\Core\app\Http\Controllers\CrudController::class, 'getModels'])->name('models.list');
    Route::get('/model-operations/{model}', [sOne\Core\app\Http\Controllers\CrudController::class, 'getModelOperations'])->name('model.operations');

    Route::get('{any}', function () {
        return view('sone::core.index');
    })->where('any', '.*');
})->middleware('auth:sanctum');;

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
