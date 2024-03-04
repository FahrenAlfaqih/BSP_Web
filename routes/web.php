<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\SertifikasiController;
use App\Http\Controllers\MagangController;
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

    Route::prefix('sertifikasi')->group(function () {
        // Menampilkan dan memfilter data sertifikasi
        Route::get('/', [SertifikasiController::class, 'index'])->name('sertifikasi');
        Route::get('/filterYear', [SertifikasiController::class, 'filterByYear'])->name('sertifikasi.filterYear');
        Route::get('/filterByMonth', [SertifikasiController::class, 'filterByMonth'])->name('sertifikasi.filterByMonth');
        Route::get('/filterData', [SertifikasiController::class, 'filterData'])->name('sertifikasi.filterData');
        // Download file PDF
        Route::get('/download-pdf', [SertifikasiController::class, 'downloadPDF'])->name('sertifikasi.download-pdf');
        // Upload file Excel untuk inputan data
        Route::post('/upload-excel', [SertifikasiController::class, 'uploadExcel'])->name('sertifikasi.upload-excel');
        // CRUD data sertifikasi
        Route::post('/store', [SertifikasiController::class, 'store'])->name('sertifikasi.store');
        Route::put('/{id}/edit', [SertifikasiController::class, 'editSertifikasi'])->name('sertifikasi.edit');
        Route::delete('/{id}', [SertifikasiController::class, 'deleteSertifikasi'])->name('sertifikasi.destroy');
    });

    Route::prefix('magang')->group(function () {
        // Menampilkan dan memfilter data sertifikasi
        Route::get('/', [MagangController::class, 'index'])->name('magang');
        Route::get('/filterYear', [MagangController::class, 'filterByYear'])->name('magang.filterYear');
        Route::get('/filterByMonth', [MagangController::class, 'filterByMonth'])->name('magang.filterByMonth');
        Route::get('/filterData', [MagangController::class, 'filterData'])->name('magang.filterData');
        // Download file PDF
        Route::get('/download-pdf', [MagangController::class, 'downloadPDF'])->name('magang.download-pdf');
        // Upload file Excel untuk inputan data
        Route::post('/uploadExcel', [MagangController::class, 'uploadExcel'])->name('magang.uploadExcel');
        // CRUD data sertifikasi
        Route::post('/store', [MagangController::class, 'store'])->name('magang.store');
        Route::put('/{id}/edit', [MagangController::class, 'editMagang'])->name('magang.edit');
        Route::delete('/{id}', [MagangController::class, 'deleteMagang'])->name('magang.destroy');
    });



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

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
