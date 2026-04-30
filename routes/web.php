<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\ServiceHistoryController;
use App\Http\Controllers\UnitEntryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/unit-entry', [UnitEntryController::class, 'index'])->name('unit-entry.index');
Route::post('/unit-entry', [UnitEntryController::class, 'store'])->name('unit-entry.store');
Route::put('/unit-entry/{id}', [UnitEntryController::class, 'update'])->name('unit-entry.update');
Route::delete('/unit-entry/{id}', [UnitEntryController::class, 'destroy'])->name('unit-entry.destroy');
Route::get('/unit-entry/export-pdf', [UnitEntryController::class, 'exportPdf'])->name('unit-entry.export-pdf');

Route::get('/mechanic', [MechanicController::class, 'index'])->name('mechanic.index');
Route::post('/mechanic', [MechanicController::class, 'store'])->name('mechanic.store');
Route::put('/mechanic/{id}', [MechanicController::class, 'update'])->name('mechanic.update');
Route::delete('/mechanic/{id}', [MechanicController::class, 'destroy'])->name('mechanic.destroy');

Route::get('/job-type', [JobTypeController::class, 'index'])->name('job-type.index');
Route::post('/job-type', [JobTypeController::class, 'store'])->name('job-type.store');
Route::put('/job-type/{id}', [JobTypeController::class, 'update'])->name('job-type.update');
Route::delete('/job-type/{id}', [JobTypeController::class, 'destroy'])->name('job-type.destroy');

Route::get('/riwayat-servis', [ServiceHistoryController::class, 'index'])->name('history.index');
Route::get('/riwayat-servis/pdf/{date}', [ServiceHistoryController::class, 'exportPdfByDate'])->name('history.pdf');
Route::delete('/riwayat-servis/{date}', [ServiceHistoryController::class, 'destroyByDate'])->name('history.destroy');
