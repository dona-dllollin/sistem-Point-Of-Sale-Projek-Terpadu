<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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

// Route::get('/', function () {
//     return view('login');
// });

Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::get('/register', [AuthController::class, 'create'])->name('registrasi');
    Route::post('/register', [AuthController::class, 'register'])->name('registrasi');
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware(['auth', 'role:admin', 'check.toko', 'inject.toko'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'viewDashboard'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:kasir', 'check.toko', 'inject.toko'])->group(function () {
    Route::get('/toko/{slug_market}', function () {
        $toko = Auth::user()->market->nama_toko;
        return view('home', compact('toko'));
    })->name('kasir.dashboard');
});
