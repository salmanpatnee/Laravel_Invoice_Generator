<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PackageController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
    Route::get('/packages/create', [PackageController::class, 'create'])->name('packages.create');
    Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
    Route::get('/packages/edit/{package}', [PackageController::class, 'edit'])->name('packages.edit');
    Route::patch('/packages/{package}', [PackageController::class, 'update'])->name('packages.update');
    Route::delete('/packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');

    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/edit/{brand}', [BrandController::class, 'edit'])->name('brands.edit');
    Route::patch('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
});
