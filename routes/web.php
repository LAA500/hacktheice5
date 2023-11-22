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

    Route::get('/profile', 'profile')->middleware('auth')->name('profile');
});

Route::group(['prefix' => 'auth'], function () {
    Auth::routes([
        'logout' => false,
        'verify' => false,
    ]);

    Route::get('/logout', [Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});

Route::get('/setCity/{city:uuid}', [Controllers\CityController::class, 'setCity'])->name('set_city');

Route::prefix('/ajax')->name('ajax.')->group(function () {
    //
});