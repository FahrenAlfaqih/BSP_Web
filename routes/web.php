<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\SertifikasiController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\DpdController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PurchaseReqController;
use App\Http\Controllers\ServiceEntryController;
use App\Http\Controllers\PreOrderController;
use App\Http\Controllers\SpdController;
use App\Http\Controllers\TrainingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home'])->name('dashboard');
    Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');

    // Route::get('dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::prefix('pegawai')->group(function () {
        Route::get('/', [PegawaiController::class, 'index'])->name('pegawai');
        Route::post('/upload-excel', [PegawaiController::class, 'uploadExcel'])->name('pegawai.upload-excel');
        Route::get('/filterByDate', [SpdController::class, 'filterByDate'])->name('pegawai.filterByDate');
        Route::get('/filterData', [SpdController::class, 'filterData'])->name('pegawai.filterData');
        Route::get('/filterByDept', [SpdController::class, 'filterByDept'])->name('pegawai.filterByDept');
        // Download file PDF
        Route::get('/download-pdf', [SpdController::class, 'downloadPDF'])->name('pegawai.download-pdf');
        // Download file Excel
        Route::get('/download-excel', [SpdController::class, 'downloadExcel'])->name('pegawai.download-excel');
        Route::post('/export-selected-pegawais', [SpdController::class, 'exportSelectedSpds'])->name('export-selected-pegawais');
        // Upload file Excel 
        // CRUD data pegawai
        Route::post('/store', [SpdController::class, 'store'])->name('pegawai.store');
        Route::put('/{id}/edit', [SpdController::class, 'editSpd'])->name('pegawai.edit');
        Route::delete('/{id}', [SpdController::class, 'deleteSpd'])->name('pegawai.destroy');
    });

    Route::prefix('departemen')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('departemen');
        Route::post('/storeDanaAwal', [DepartmentController::class, 'updateInitialFunds'])->name('updateInitialFunds');
    });


    Route::prefix('dpd')->group(function () {
        // Menampilkan dan memfilter data DPD
        Route::get('/', [DpdController::class, 'index'])->name('dpd');
        Route::get('/filterByDate', [DpdController::class, 'filterByDate'])->name('dpd.filterByDate');
        Route::get('/filterByDept', [DpdController::class, 'filterByDept'])->name('dpd.filterByDept');
        Route::get('/filterData', [DpdController::class, 'filterData'])->name('dpd.filterData');
        // Download file PDFs
        Route::get('/download-pdf', [DpdController::class, 'downloadPDF'])->name('dpd.download-pdf');
        Route::get('/download-excel', [DpdController::class, 'downloadExcel'])->name('dpd.download-excel');
        // Upload file Excel untuk input data
        Route::post('/uploadExcel', [DpdController::class, 'uploadExcel'])->name('dpd.uploadExcel');

        // CRUD data DPD
        Route::post('/store', [DpdController::class, 'store'])->name('dpd.store');
        Route::post('/storeDanaAwal', [DepartmentController::class, 'updateInitialFunds'])->name('updateInitialFunds');
        Route::put('/{id}/edit', [DpdController::class, 'editDpd'])->name('dpd.edit');
        Route::delete('/{id}', [DpdController::class, 'deleteDpd'])->name('dpd.destroy');
    });


    Route::prefix('spd')->group(function () {
        // Menampilkan dan memfilter data spd
        Route::get('/', [SpdController::class, 'index'])->name('spd');
        Route::get('/filterByDate', [SpdController::class, 'filterByDate'])->name('spd.filterByDate');
        Route::get('/filterData', [SpdController::class, 'filterData'])->name('spd.filterData');
        Route::get('/filterByDept', [SpdController::class, 'filterByDept'])->name('spd.filterByDept');
        // Download file PDF
        Route::get('/download-pdf', [SpdController::class, 'downloadPDF'])->name('spd.download-pdf');
        // Download file Excel
        Route::get('/download-excel', [SpdController::class, 'downloadExcel'])->name('spd.download-excel');
        Route::post('/export-selected-spds', [SpdController::class, 'exportSelectedSpds'])->name('export-selected-spds');
        // Upload file Excel 
        Route::post('/uploadExcel', [SpdController::class, 'uploadExcel'])->name('spd.uploadExcel');
        // CRUD data spd
        Route::post('/store', [SpdController::class, 'store'])->name('spd.store');
        Route::put('/{id}/edit', [SpdController::class, 'editSpd'])->name('spd.edit');
        Route::delete('/{id}', [SpdController::class, 'deleteSpd'])->name('spd.destroy');
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
    Route::get('/reload-captcha', [SessionsController::class, 'reloadCaptcha']);
    Route::post('/session', [SessionsController::class, 'store']);
    Route::get('/login/forgot-password', [ResetController::class, 'create']);
    Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
    Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');
