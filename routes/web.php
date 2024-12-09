<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

// Route::get('/', function () {
//     return view('login');
// });

Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::get('/register', [AuthController::class, 'create'])->name('registrasi');
    Route::post('/register', [AuthController::class, 'register'])->name('registrasi');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    //product
    Route::post('/product/create', [ProductController::class, 'createProduct']);
    Route::get('/product/edit/{id}', [ProductController::class, 'editProduct']);
    Route::post('/product/update', [ProductController::class, 'updateProduct']);

    // transaction
    Route::post('/transaction/product/{id}', [TransactionController::class, 'transactionProduct']);
    Route::get('/transaction/product/check/{id}', [TransactionController::class, 'transactionProductCheck']);
    Route::post('/cart/increase/{id}', [TransactionController::class, 'increaseQuantity']);
    Route::post('/cart/decrease/{id}', [TransactionController::class, 'decreaseQuantity']);
    Route::post('/cart/remove/{id}', [TransactionController::class, 'removeItem']);
    Route::post('/transaction/process', [TransactionController::class, 'transactionProcess']);
    Route::get('/transaction/receipt/{id}', [TransactionController::class, 'receiptTransaction']);
});

Route::middleware(['auth', 'role:admin', 'check.toko', 'inject.toko'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'viewDashboard'])->name('admin.dashboard');
    Route::get('/product', [ProductController::class, 'viewProduct'])->name('admin.product');
    Route::post('/product/delete/{id}', [ProductController::class, 'deleteProduct']);
    Route::get('/product/new', [ProductController::class, 'viewNewProduct']);
    Route::get('/transaksi', [TransactionController::class, 'index'])->name('admin.transaction');

    //karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('admin.karyawan');
    Route::post('/karyawan', [KaryawanController::class, 'store']);
    Route::post('/karyawan/delete/{id}', [KaryawanController::class, 'delete']);
    Route::post('/karyawan/edit', [KaryawanController::class, 'edit']);
});

Route::middleware(['auth', 'role:kasir', 'check.toko', 'inject.toko'])->group(function () {
    Route::get('/toko/{slug_market}', [DashboardController::class, 'viewDashboard'])->name('kasir.dashboard');
    Route::get('/toko/{slug_market}/product', [ProductController::class, 'viewProduct'])->name('kasir.product');
    Route::post('/toko/{slug_market}/product/delete/{id}', [ProductController::class, 'deleteProductKasir'])->name('product.delete');
    Route::get('/toko/{slug_market}/product/new', [ProductController::class, 'viewNewProduct'])->name('product.new');
    Route::get('/transaksi/{slug_market}', [TransactionController::class, 'index'])->name('kasir.transaction');
});
