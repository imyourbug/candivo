<?php

use App\Http\Controllers\HelpCenterController;
use Illuminate\Support\Facades\Route;

Route::get('/issue-types/tree', [HelpCenterController::class, 'issueTypesTree'])->name('api.issue-types.tree');
Route::get('/issue-types/{slug}', [HelpCenterController::class, 'issueDetail'])->name('api.issue-types.detail');
