<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
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

Route::controller(Controllers\PageController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/shop/{shop:uuid}', 'shop')->name('shop');
});

Auth::routes();

Route::prefix('/ajax')->name('ajax.')->group(function () {
    Route::get('/setCity/{city:uuid}', [Controllers\CityController::class, 'setCity'])->name('set_city');
});