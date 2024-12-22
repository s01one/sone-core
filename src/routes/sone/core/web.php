<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| sOne\Core Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the sOne\Core package.
|
*/

Route::group([
    'namespace' => 'sOne\Core\app\Http\Controllers\Api',
    'prefix' => config('sone::sone.core.prefix_web', 'admin'),
    'middleware' => ['web'],
], function () {
    Route::get('/', function () {
        return view('sone::core.index');
    });
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

    Route::post('{model}/bulk-delete', [CrudController::class, 'bulkDelete'])->name('bulkDelete');
    Route::post('{model}/import', [CrudController::class, 'import'])->name('import');
    Route::get('{model}/export', [CrudController::class, 'export'])->name('export');

    Route::fallback(function () {
        return response()->view('sone::core.errors.404', [], 404);
    });
});
