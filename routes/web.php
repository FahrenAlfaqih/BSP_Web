<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\SertifikasiController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\PoReimburstController;
use App\Http\Controllers\PrReimburstController;
use App\Http\Controllers\SesReimburstController;
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
        Route::get('/filterByDate', [SertifikasiController::class, 'filterByDate'])->name('sertifikasi.filterByDate');
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

    Route::prefix('prreimburst')->group(function () {
        // Menampilkan dan memfilter data sertifikasi
        Route::get('/', [PrReimburstController::class, 'index'])->name('[prreimburst]');
        Route::get('/filterData', [PrReimburstController::class, 'filterData'])->name('prreimburst.filterData');
        // Download file PDF
        Route::get('/download-excel', [PrReimburstController::class, 'downloadExcel'])->name('prreimburst.download-excel');
        // Upload file Excel untuk inputan data
        Route::post('/uploadExcel', [PrReimburstController::class, 'uploadExcel'])->name('prreimburst.uploadExcel');
        // CRUD data sertifikasi
        Route::post('/store', [PrReimburstController::class, 'store'])->name('prreimburst.store');
        Route::put('/{id}/edit', [PrReimburstController::class, 'editPrreimburst'])->name('prreimburst.edit');
        Route::delete('/{id}', [PrReimburstController::class, 'deletePrreimburst'])->name('prreimburst.destroy');
    });
    Route::prefix('poreimburst')->group(function () {
        // Menampilkan dan memfilter data sertifikasi
        Route::get('/', [PoReimburstController::class, 'index'])->name('[poreimburst]');
        Route::get('/filterData', [PoReimburstController::class, 'filterData'])->name('poreimburst.filterData');
        // Download file PDF
        Route::get('/download-pdf', [PoReimburstController::class, 'downloadPDF'])->name('poreimburst.download-pdf');
        // Upload file Excel untuk inputan data
        Route::post('/uploadExcel', [PoReimburstController::class, 'uploadExcel'])->name('poreimburst.uploadExcel');
        // CRUD data sertifikasi
        Route::post('/store', [PoReimburstController::class, 'store'])->name('poreimburst.store');
        Route::put('/{id}/edit', [PoReimburstController::class, 'editPrreimburst'])->name('poreimburst.edit');
        Route::delete('/{id}', [PoReimburstController::class, 'deletePrreimburst'])->name('poreimburst.destroy');
    });

    Route::prefix('sesreimburst')->group(function () {
        // Menampilkan dan memfilter data sertifikasi
        Route::get('/', [SesReimburstController::class, 'index'])->name('[sesreimburst]');
        Route::get('/filterData', [SesReimburstController::class, 'filterData'])->name('sesreimburst.filterData');
        // Download file PDF
        Route::get('/download-pdf', [SesReimburstController::class, 'downloadPDF'])->name('sesreimburst.download-pdf');
        // Upload file Excel untuk inputan data
        Route::post('/uploadExcel', [SesReimburstController::class, 'uploadExcel'])->name('sesreimburst.uploadExcel');
        // CRUD data sertifikasi
        Route::post('/store', [SesReimburstController::class, 'store'])->name('sesreimburst.store');
        Route::put('/{id}/edit', [SesReimburstController::class, 'editPrreimburst'])->name('sesreimburst.edit');
        Route::delete('/{id}', [SesReimburstController::class, 'deletePrreimburst'])->name('sesreimburst.destroy');
    });

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