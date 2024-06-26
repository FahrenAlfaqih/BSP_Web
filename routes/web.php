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

    Route::prefix('sertifikasi')->group(function () {
        // Menampilkan dan memfilter data sertifikasi
        Route::get('/', [SertifikasiController::class, 'index'])->name('sertifikasi');
        Route::get('/filterByDate', [SertifikasiController::class, 'filterByDate'])->name('sertifikasi.filterByDate');
        Route::get('/filterData', [SertifikasiController::class, 'filterData'])->name('sertifikasi.filterData');
        Route::get('/filterByNamaProgram', [SertifikasiController::class, 'filterByNamaProgram'])->name('sertifikasi.filterByNamaProgram');
        Route::get('/filterByDept', [SertifikasiController::class, 'filterByDept'])->name('sertifikasi.filterByDept');

        // Download file PDF
        Route::get('/download-pdf', [SertifikasiController::class, 'downloadPDF'])->name('sertifikasi.download-pdf');
        // Upload file Excel untuk inputan data
        Route::post('/upload-excel', [SertifikasiController::class, 'uploadExcel'])->name('sertifikasi.upload-excel');
        // CRUD data sertifikasi
        Route::post('/store', [SertifikasiController::class, 'store'])->name('sertifikasi.store');
        Route::put('/{id}/edit', [SertifikasiController::class, 'editSertifikasi'])->name('sertifikasi.edit');
        Route::delete('/{id}', [SertifikasiController::class, 'deleteSertifikasi'])->name('sertifikasi.destroy');
    });

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

    Route::prefix('training')->group(function () {
        // Menampilkan dan memfilter data sertifikasi
        Route::get('/', [TrainingController::class, 'index'])->name('training');
        Route::post('/upload-excel', [TrainingController::class, 'uploadExcel'])->name('training.upload-excel');
        // CRUD data sertifikasi
        Route::post('/store', [TrainingController::class, 'store'])->name('training.store');
        Route::put('/{id}/edit', [TrainingController::class, 'editTraining'])->name('training.edit');
        Route::delete('/{id}', [TrainingController::class, 'deleteTraining'])->name('training.destroy');
    });

    Route::prefix('magang')->group(function () {
        // Menampilkan dan memfilter data magang
        Route::get('/', [MagangController::class, 'index'])->name('magang');
        Route::get('/filterByDate', [MagangController::class, 'filterByDate'])->name('magang.filterByDate');
        Route::get('/filterData', [MagangController::class, 'filterData'])->name('magang.filterData');
        Route::get('/filterByDept', [MagangController::class, 'filterByDept'])->name('magang.filterByDept');

        // Download file PDF
        Route::get('/download-pdf', [MagangController::class, 'downloadPDF'])->name('magang.download-pdf');
        // Upload file Excel untuk inputan data
        Route::post('/uploadExcel', [MagangController::class, 'uploadExcel'])->name('magang.uploadExcel');
        // CRUD data Magang
        Route::post('/store', [MagangController::class, 'store'])->name('magang.store');
        Route::put('/{id}/edit', [MagangController::class, 'editMagang'])->name('magang.edit');
        Route::delete('/{id}', [MagangController::class, 'deleteMagang'])->name('magang.destroy');
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

    Route::prefix('pr')->group(function () {
        Route::get('/', [PurchaseReqController::class, 'index'])->name('prreimburst');
        Route::get('/prservice', [PurchaseReqController::class, 'indexService'])->name('prservice');
        Route::get('/prnonada', [PurchaseReqController::class, 'indexNonAda'])->name('prnonada');

        Route::get('/filterData', [PurchaseReqController::class, 'filterData'])->name('prreimburst.filterData');
        Route::get('/filterDataService', [PurchaseReqController::class, 'filterDataService'])->name('prservice.filterData');
        Route::get('/filterDataNonada', [PurchaseReqController::class, 'filterDataNonada'])->name('prnonada.filterData');

        Route::get('/download-excel', [PurchaseReqController::class, 'downloadExcel'])->name('prreimburst.download-excel');
        Route::get('/download-excel-prservice', [PurchaseReqController::class, 'downloadExcelPrService'])->name('prservice.download-excel');
        Route::get('/download-excel-prnonada', [PurchaseReqController::class, 'downloadExcelPrNonada'])->name('prnonada.download-excel');

        Route::post('/uploadExcel', [PurchaseReqController::class, 'uploadExcel'])->name('prreimburst.uploadExcel');
        Route::post('/uploadExcel-prservice', [PurchaseReqController::class, 'uploadExcelService'])->name('prservice.uploadExcel');
        Route::post('/uploadExcel-prnonada', [PurchaseReqController::class, 'uploadExcelNonada'])->name('prnonada.uploadExcel');

        Route::post('/store', [PurchaseReqController::class, 'store'])->name('prreimburst.store');
        Route::post('/store-poservice', [PurchaseReqController::class, 'storeService'])->name('pr.storePrService');
        Route::post('/store-pononada', [PurchaseReqController::class, 'storeNonada'])->name('pr.storePrNonada');

        Route::put('/{id}/edit', [PurchaseReqController::class, 'editPrreimburst'])->name('prreimburst.edit');
        Route::put('/prservices/{id}/edit', [PurchaseReqController::class, 'editPrService'])->name('prservice.edit');
        Route::put('/prnonada/{id}/edit', [PurchaseReqController::class, 'editPrNonada'])->name('prnonada.edit');

        Route::delete('/prreimburst/{id}', [PurchaseReqController::class, 'deletePrreimburst'])->name('prreimburst.destroy');
        Route::delete('/prservice/{id}', [PurchaseReqController::class, 'deletePrService'])->name('prservice.destroy');
        Route::delete('/prnonada/{id}', [PurchaseReqController::class, 'deletePrNonada'])->name('prnonada.destroy');
    });

    Route::prefix('po')->group(function () {
        Route::get('/', [PreOrderController::class, 'index'])->name('poreimburst');
        Route::get('/poservice', [PreOrderController::class, 'indexService'])->name('poservice');
        Route::get('/pononada', [PreOrderController::class, 'indexNonAda'])->name('pononada');

        Route::get('/filterData', [PreOrderController::class, 'filterData'])->name('poreimburst.filterData');
        Route::get('/filterDataNonada', [PreOrderController::class, 'filterDataNonada'])->name('pononada.filterData');
        Route::get('/filterDataService', [PreOrderController::class, 'filterDataService'])->name('poservice.filterData');

        Route::get('/download-pdf', [PreOrderController::class, 'downloadPDF'])->name('poreimburst.download-pdf');
        Route::get('/download-pdf-pononada', [PreOrderController::class, 'downloadPDF'])->name('pononada.download-pdf');
        Route::get('/download-pdf-poservice', [PreOrderController::class, 'downloadPDF'])->name('poservice.download-pdf');

        Route::get('/download-excel', [PreOrderController::class, 'downloadExcel'])->name('poreimburst.download-excel');
        Route::get('/download-excel-pononada', [PreOrderController::class, 'downloadExcelPoNonada'])->name('pononada.download-excel');
        Route::get('/download-excel-poservice', [PreOrderController::class, 'downloadExcelPoService'])->name('poservice.download-excel');

        Route::post('/uploadExcel', [PreOrderController::class, 'uploadExcel'])->name('poreimburst.uploadExcel');
        Route::post('/uploadExcel-pononada', [PreOrderController::class, 'uploadExcel'])->name('pononada.uploadExcel');
        Route::post('/uploadExcel-poservice', [PreOrderController::class, 'uploadExcel'])->name('poservice.uploadExcel');

        Route::post('/store', [PreOrderController::class, 'store'])->name('poreimburst.store');
        Route::post('/store-pononada', [PreOrderController::class, 'storePoNonAda'])->name('pononada.store');
        Route::post('/store-poservice', [PreOrderController::class, 'storePoService'])->name('poservice.store');

        Route::put('/{id}/edit', [PreOrderController::class, 'editPoReimburst'])->name('poreimburst.edit');
        Route::put('/pononada/{id}/edit', [PreOrderController::class, 'editPoNonada'])->name('pononada.edit');
        Route::put('/poservice/{id}/edit', [PreOrderController::class, 'editPoService'])->name('poservice.edit');

        Route::delete('/poreimburst/{id}', [PreOrderController::class, 'deletePoreimburst'])->name('poreimburst.destroy');
        Route::delete('/pononada/{id}', [PreOrderController::class, 'deletePoNonada'])->name('pononada.destroy');

        Route::delete('/poservice/{id}', [PreOrderController::class, 'deletePoService'])->name('poservice.destroy');
    });

    Route::prefix('ses')->group(function () {
        Route::get('/', [ServiceEntryController::class, 'index'])->name('sesreimburst');
        Route::get('/sesservice', [ServiceEntryController::class, 'indexService'])->name('sesservice');
        Route::get('/sesnonada', [ServiceEntryController::class, 'indexNonada'])->name('sesnonada');

        Route::get('/filterData', [ServiceEntryController::class, 'filterData'])->name('sesreimburst.filterData');
        Route::get('/filterDataNonada', [ServiceEntryController::class, 'filterDataNonada'])->name('sesnonada.filterData');
        Route::get('/filterDataService', [ServiceEntryController::class, 'filterDataService'])->name('sesservice.filterData');

        Route::get('/download-pdf', [ServiceEntryController::class, 'downloadPDF'])->name('sesreimburst.download-pdf');

        Route::get('/download-excel', [ServiceEntryController::class, 'downloadExcel'])->name('sesreimburst.download-excel');
        Route::get('/download-excel-sesservice', [ServiceEntryController::class, 'downloadExcelService'])->name('sesservice.download-excel');
        Route::get('/download-excel-sesnonada', [ServiceEntryController::class, 'downloadExcelNonada'])->name('sesnonada.download-excel');

        Route::post('/uploadExcel', [ServiceEntryController::class, 'uploadExcel'])->name('sesreimburst.uploadExcel');

        Route::post('/store', [ServiceEntryController::class, 'store'])->name('sesreimburst.store');
        Route::post('/storeService', [ServiceEntryController::class, 'storeService'])->name('sesservice.store');
        Route::post('/storeNonada', [ServiceEntryController::class, 'storeNonada'])->name('sesnonada.store');

        Route::put('/{id}/edit', [ServiceEntryController::class, 'editSesReimburst'])->name('sesreimburst.edit');
        Route::put('/sesservice/{id}/edit', [ServiceEntryController::class, 'editSesService'])->name('sesservice.edit');
        Route::put('/sesnonada/{id}/edit', [ServiceEntryController::class, 'editSesNonada'])->name('sesnonada.edit');

        Route::delete('/{id}', [ServiceEntryController::class, 'deleteSesreimburst'])->name('sesreimburst.destroy');
        Route::delete('/sesservice/{id}', [ServiceEntryController::class, 'deleteSesService'])->name('sesservice.destroy');
        Route::delete('/sesnonada/{id}', [ServiceEntryController::class, 'deleteSesNonada'])->name('sesnonada.destroy');
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
