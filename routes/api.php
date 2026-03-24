<?php

use App\Http\Controllers\Admin\AdminMediaConfigController;
use App\Http\Controllers\HelpCenterController;
use Illuminate\Support\Facades\Route;

Route::get('/issue-types/tree', [HelpCenterController::class, 'issueTypesTree'])->name('api.issue-types.tree');
Route::get('/issue-types/{slug}', [HelpCenterController::class, 'issueDetail'])->name('api.issue-types.detail');
Route::post('/help-center/schedule-request', [HelpCenterController::class, 'sendScheduleRequestMail'])
    ->name('api.help-center.schedule-request');

Route::middleware(['web', 'auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('media/client-config', [AdminMediaConfigController::class, 'clientConfig'])
            ->name('media.client-config');
    });
