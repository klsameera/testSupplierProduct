<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;

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

Route::get('/', [HomeController::class, "index"])->name('dashboard');

Route::prefix('suppliers')->group(function () {
    Route::get('/', [SupplierController::class, "index"])->name('suppliers.index');
    Route::get('/all', [SupplierController::class, "all"])->name('suppliers.all');
    Route::get('/all/dropdown', [SupplierController::class, "allDropdown"])->name('suppliers.all.dropdown');
    Route::post('/store', [SupplierController::class, "store"])->name('suppliers.store');
    Route::delete('/{supplier_id}/delete', [SupplierController::class, "delete"])->name('suppliers.delete');
    Route::get('/{supplier_id}/get', [SupplierController::class, "get"])->name('suppliers.get');
    Route::get('/{supplier_id}/status', [SupplierController::class, "status"])->name('suppliers.status');
    Route::post('/{supplier_id}/update', [SupplierController::class, "update"])->name('suppliers.update');
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, "index"])->name('products.index');
    Route::get('/all', [ProductController::class, "all"])->name('products.all');
    Route::post('/store', [ProductController::class, "store"])->name('products.store');
    Route::delete('/{product_id}/delete', [ProductController::class, "delete"])->name('products.delete');
    Route::get('/{product_id}/get', [ProductController::class, "get"])->name('products.get');
    Route::get('/{product_id}/status', [ProductController::class, "status"])->name('products.status');
    Route::post('/{product_id}/update', [ProductController::class, "update"])->name('products.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
