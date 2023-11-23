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
    Route::get('/product/{product:uuid}', 'product')->name('product');

    Route::get('/cart', 'cart')->name('cart');
    Route::get('/checkout', 'checkout')->name('checkout');

    Route::get('/delivery', 'delivery')->name('delivery');
    Route::get('/documents', 'documents')->name('documents');
    Route::get('/categories', 'categories')->name('categories');

    Route::get('/order/{order:uuid}/complete', 'complete')->name('complete');
});

Route::prefix('/profile')->name('profile.')->middleware('auth')->controller(Controllers\ProfileController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/orders', 'orders')->name('orders');
    Route::get('/addresses', 'addresses')->name('addresses');
    Route::get('/favorites', 'favorites')->name('favorites');
});

Route::get('/setCity/{city:uuid}', [Controllers\CityController::class, 'setCity'])->name('set_city');

Route::prefix('/ajax')->name('ajax.')->group(function () {
    Route::post('/cart/{act}', [Controllers\CartController::class, 'act'])->whereIn('act', ['add', 'clear', 'recalc', 'remove'])->name('cart.act');
    Route::post('/purchase', [Controllers\OrderController::class, 'store'])->name('purchase');
});

Route::get('/select-role', [Controllers\SelectRoleController::class, 'index'])->middleware('auth')->name('select_role');
Route::get('/select-role/set/{role}', [Controllers\SelectRoleController::class, 'set'])->middleware('auth')->name('select_role.set');

Route::prefix('/admin')->name('admin.')->controller(Controllers\AdminController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');

    Route::resource('products', Controllers\ProductController::class);
    Route::resource('categories', Controllers\CategoryController::class);
    Route::resource('orders', Controllers\OrderController::class);
    Route::resource('users', Controllers\Admin\UserController::class)->except(['show']);
    Route::resource('supplies', Controllers\SupplyController::class);
});

Route::group(['prefix' => 'auth'], function () {
    Auth::routes([
        'logout' => false,
        'verify' => false,
    ]);

    Route::get('/logout', [Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});
