<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\LauncherController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\RelatoriuController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LauncherController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.post')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth.check'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/error', [ErrorController::class, 'index'])->name('error');

    Route::get('/password', [ChangePasswordController::class, 'showForm'])->name('password');
    Route::post('/password', [ChangePasswordController::class, 'update'])->name('password.update');

    Route::prefix('barang')->name('barang.')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('index');
        Route::get('/create', [BarangController::class, 'create'])->name('create');
        Route::get('/edit', [BarangController::class, 'edit'])->name('edit');
        Route::post('/store', [BarangController::class, 'store'])->name('store');
        Route::get('/delete', [BarangController::class, 'destroy'])->name('delete');
    });

    Route::middleware('role:1,2')->prefix('supplier')->name('supplier.')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('index');
        Route::get('/create', [SupplierController::class, 'create'])->name('create');
        Route::get('/edit', [SupplierController::class, 'edit'])->name('edit');
        Route::post('/store', [SupplierController::class, 'store'])->name('store');
        Route::put('/update', [SupplierController::class, 'update'])->name('update');
        Route::get('/delete', [SupplierController::class, 'destroy'])->name('delete');
    });

    Route::middleware('role:1,2')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::get('/edit', [CustomerController::class, 'edit'])->name('edit');
        Route::post('/store', [CustomerController::class, 'store'])->name('store');
        Route::put('/update', [CustomerController::class, 'update'])->name('update');
        Route::get('/delete', [CustomerController::class, 'destroy'])->name('delete');
    });

    Route::middleware('role:1')->prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::get('/edit', [UserController::class, 'edit'])->name('edit');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::put('/update', [UserController::class, 'update'])->name('update');
        Route::get('/delete', [UserController::class, 'destroy'])->name('delete');
    });

    Route::prefix('pembelian')->name('pembelian.')->group(function () {
        Route::get('/', [PembelianController::class, 'index'])->name('index');
        Route::post('/add', [PembelianController::class, 'addBarang'])->name('add');
        Route::get('/delete', [PembelianController::class, 'deleteBarang'])->name('delete');
        Route::post('/simpan', [PembelianController::class, 'simpan'])->name('simpan');
    });

    Route::prefix('penjualan')->name('penjualan.')->group(function () {
        Route::get('/', [PenjualanController::class, 'index'])->name('index');
        Route::post('/add', [PenjualanController::class, 'addBarang'])->name('add');
        Route::get('/delete', [PenjualanController::class, 'deleteBarang'])->name('delete');
        Route::post('/simpan', [PenjualanController::class, 'simpan'])->name('simpan');
    });

    Route::get('/stock', [StockController::class, 'index'])->name('stock');

    Route::prefix('report')->name('report.')->group(function () {
        Route::get('/r-jual', [ReportController::class, 'rJual'])->name('jual');
        Route::get('/r-beli', [ReportController::class, 'rBeli'])->name('beli');
        Route::get('/r-stock', [ReportController::class, 'rStock'])->name('stock');
        Route::get('/r-barcode', [ReportController::class, 'rBarcode'])->name('barcode');
        Route::get('/r-struk', [PenjualanController::class, 'struk'])->name('struk');
    });

    Route::prefix('relatoriu')->name('relatoriu.')->group(function () {
        Route::get('/makfaan', [RelatoriuController::class, 'makfaan'])->name('makfaan');
        Route::get('/makfaan/detail', [RelatoriuController::class, 'detailPenjualan'])->name('makfaan.detail');
        Route::get('/maksosak', [RelatoriuController::class, 'maksosak'])->name('maksosak');
        Route::get('/maksosak/detail', [RelatoriuController::class, 'detailPembelian'])->name('maksosak.detail');
    });
});
