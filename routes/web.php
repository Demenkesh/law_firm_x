<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::controller(App\Http\Controllers\ClientController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('store_client', 'store');
    Route::get('get_client/{id}', 'edit');
    Route::put('update_client/{id}', 'update')->name('update_client');
    Route::get('cron_job', 'withoutimage');
});
