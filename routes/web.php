<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceHistoryController;
use App\Http\Controllers\UnitEntryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:super_admin|viewer'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/riwayat-servis', [ServiceHistoryController::class, 'index'])->name('history.index');
        Route::get('/riwayat-servis/pdf/{date}', [ServiceHistoryController::class, 'exportPdfByDate'])->name('history.pdf');
    });

    Route::middleware(['role:super_admin|entry'])->group(function () {
        Route::get('/unit-entry', [UnitEntryController::class, 'index'])->name('unit-entry.index');
        Route::post('/unit-entry', [UnitEntryController::class, 'store'])->name('unit-entry.store');
        Route::get('/unit-entry/export-pdf', [UnitEntryController::class, 'exportPdf'])->name('unit-entry.export-pdf');
    });

    Route::middleware(['role:super_admin'])->group(function () {
        Route::put('/unit-entry/{id}', [UnitEntryController::class, 'update'])->name('unit-entry.update');
        Route::delete('/unit-entry/{id}', [UnitEntryController::class, 'destroy'])->name('unit-entry.destroy');

        Route::delete('/riwayat-servis/{date}', [ServiceHistoryController::class, 'destroyByDate'])->name('history.destroy');

        Route::get('/mechanic', [MechanicController::class, 'index'])->name('mechanic.index');
        Route::post('/mechanic', [MechanicController::class, 'store'])->name('mechanic.store');
        Route::put('/mechanic/{id}', [MechanicController::class, 'update'])->name('mechanic.update');
        Route::delete('/mechanic/{id}', [MechanicController::class, 'destroy'])->name('mechanic.destroy');

        Route::get('/job-type', [JobTypeController::class, 'index'])->name('job-type.index');
        Route::post('/job-type', [JobTypeController::class, 'store'])->name('job-type.store');
        Route::put('/job-type/{id}', [JobTypeController::class, 'update'])->name('job-type.update');
        Route::delete('/job-type/{id}', [JobTypeController::class, 'destroy'])->name('job-type.destroy');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });

});

require __DIR__.'/auth.php';
