<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\SertifikasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('sertifikasi', [SertifikasiController::class, 'index'])->name('sertifikasi');
    Route::get('sertifikasi/filterYear', [SertifikasiController::class, 'filterByYear'])->name('sertifikasi.filterYear');
    Route::get('sertifikasi/filterNamaProgram', [SertifikasiController::class, 'filterByNamaProgram'])->name('sertifikasi.filterNamaProgram');
    Route::get('/sertifikasi/download-pdf', [SertifikasiController::class, 'downloadPDF'])->name('sertifikasi.download-pdf');

    //CRUD DATA SERTIFIKASI
    Route::post('/sertifikasi/store', [SertifikasiController::class, 'store'])->name('sertifikasi.store');
    Route::get('/sertifikasi/{id}/edit', [SertifikasiController::class, 'editSertifikasi'])->name('sertifikasi.edit');
    Route::delete('/sertifikasi/{id}', [SertifikasiController::class, 'deleteSertifikasi'])->name('sertifikasi.destroy');

    Route::get('billing', function () {
        return view('billing');
    })->name('billing');

    Route::get('profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('rtl', function () {
        return view('rtl');
    })->name('rtl');

    Route::get('user-management', function () {
        return view('laravel-examples/user-management');
    })->name('user-management');

    Route::get('tables', function () {
        return view('tables');
    })->name('tables');

    Route::get('virtual-reality', function () {
        return view('virtual-reality');
    })->name('virtual-reality');

    Route::get('static-sign-up', function () {
        return view('static-sign-up');
    })->name('sign-up');

    Route::get('/logout', [SessionsController::class, 'destroy']);
    Route::get('/user-profile', [InfoUserController::class, 'create']);
    Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
        return view('dashboard');
    })->name('sign-up');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
    Route::get('/login/forgot-password', [ResetController::class, 'create']);
    Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
    Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');
