<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Telegram\BotController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('panel.contest.index');
});

Route::any('telegram_bot', [BotController::class, 'index'])
    ->name('telegram_bot');

require __DIR__.'/auth.php';

Auth::routes();
