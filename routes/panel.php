<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\Contest\ContestController;
use App\Http\Controllers\Panel\DashBoard\DashBoardController;

//Route::get('panel', [DashBoardController::class, 'index'])
//    ->name('panel.dashboard.index');

Route::controller(ContestController::class)->prefix('/contest')->group(function () {
    Route::get('/', 'index')->name('panel.contest.index');
    Route::get('/create', 'create')->name('panel.contest.create');
    Route::get('/edit/{contest}', 'edit')->name('panel.contest.edit');
    Route::post('/update/{contest}', 'update')->name('panel.contest.update');
    Route::post('/updateImage/{contest}', 'updateImage')->name('panel.contest.updateImage');
    Route::post('/deleteImage/{contest}', 'deleteImage')->name('panel.contest.deleteImage');
    Route::delete('/delete', 'delete')->name('panel.contest.delete');
    Route::get('/members/{contest}', 'members_index')->name('panel.contest.members.index');
});


