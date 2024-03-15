<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\SertifikasiController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\PurchaseReqController;
use App\Http\Controllers\SesReimburstController;
use App\Http\Controllers\PreOrderController;
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

    Route::get('/', [HomeController::class, 'home'])->name('dashboard');
    Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');

    // Route::get('dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::prefix('sertifikasi')->group(function () {
        // Menampilkan dan memfilter data sertifikasi
        Route::get('/', [SertifikasiController::class, 'index'])->name('sertifikasi');
        Route::get('/filterByDate', [SertifikasiController::class, 'filterByDate'])->name('sertifikasi.filterByDate');
        Route::get('/filterData', [SertifikasiController::class, 'filterData'])->name('sertifikasi.filterData');
        Route::get('/filterByNamaProgram', [SertifikasiController::class, 'filterByNamaProgram'])->name('sertifikasi.filterByNamaProgram');

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
        Route::get('/filterByDate', [MagangController::class, 'filterByDate'])->name('magang.filterByDate');
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




    Route::prefix('pr')->group(function () {
        Route::get('/', [PurchaseReqController::class, 'index'])->name('prreimburst');
        Route::get('/service', [PurchaseReqController::class, 'indexService'])->name('prservice');
        Route::get('/nonada', [PurchaseReqController::class, 'indexNonAda'])->name('prnonada');

        Route::get('/filterData', [PurchaseReqController::class, 'filterData'])->name('prreimburst.filterData');
        Route::get('/download-excel', [PurchaseReqController::class, 'downloadExcel'])->name('prreimburst.download-excel');
        Route::post('/uploadExcel', [PurchaseReqController::class, 'uploadExcel'])->name('prreimburst.uploadExcel');
        Route::post('/store', [PurchaseReqController::class, 'store'])->name('prreimburst.store');
        Route::put('/{id}/edit', [PurchaseReqController::class, 'editPrreimburst'])->name('prreimburst.edit');
        Route::delete('/{id}', [PurchaseReqController::class, 'deletePrreimburst'])->name('prreimburst.destroy');
    });

    Route::prefix('po')->group(function () {
        Route::get('/', [PreOrderController::class, 'index'])->name('poreimburst');
        Route::get('/filterData', [PreOrderController::class, 'filterData'])->name('poreimburst.filterData');
        Route::get('/download-pdf', [PreOrderController::class, 'downloadPDF'])->name('poreimburst.download-pdf');
        Route::get('/download-excel', [PreOrderController::class, 'downloadExcel'])->name('poreimburst.download-excel');
        Route::post('/uploadExcel', [PreOrderController::class, 'uploadExcel'])->name('poreimburst.uploadExcel');
        Route::post('/store', [PreOrderController::class, 'store'])->name('poreimburst.store');
        Route::put('/{id}/edit', [PreOrderController::class, 'editPrreimburst'])->name('poreimburst.edit');
        Route::delete('/{id}', [PreOrderController::class, 'deletePrreimburst'])->name('poreimburst.destroy');
    });

    Route::prefix('ses')->group(function () {
        Route::get('/', [SesReimburstController::class, 'index'])->name('sesreimburst');
        Route::get('/filterData', [SesReimburstController::class, 'filterData'])->name('sesreimburst.filterData');
        Route::get('/download-pdf', [SesReimburstController::class, 'downloadPDF'])->name('sesreimburst.download-pdf');
        Route::get('/download-excel', [SesReimburstController::class, 'downloadExcel'])->name('sesreimburst.download-excel');
        Route::post('/uploadExcel', [SesReimburstController::class, 'uploadExcel'])->name('sesreimburst.uploadExcel');
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
