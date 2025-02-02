<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\ToolKitController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\CctvController;
use App\Http\Controllers\TabletMonitorController;
use App\Http\Controllers\WebcamController;
use App\Http\Controllers\PCLapController;
use App\Http\Controllers\PrinterController;

Route::get('/', function () {
    return view('login');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

Route::get('/katalog/sparepart', [SparepartController::class, 'index'])->name('sparepart.index');
Route::post('/katalog/sparepart/store', [SparepartController::class, 'store'])->name('sparepart.store');
Route::put('/katalog/spareparts/{id}', [SparepartController::class, 'update'])->name('spareparts.update');
Route::delete('/katalog/spareparts/{id}', [SparepartController::class, 'destroy'])->name('spareparts.destroy');


Route::get('/katalog/toolkit', [ToolKitController::class, 'index']);

Route::get('/katalog/network', [NetworkController::class, 'index']);

Route::get('/katalog/cctv', [CctvController::class, 'index']);

Route::get('/katalog/tabletmonitor', [TabletMonitorController::class, 'index']);

Route::get('/katalog/webcam', [WebcamController::class, 'index']);

Route::get('/katalog/pclaptop', [PCLapController::class, 'index']);

Route::get('/katalog/printer', [PrinterController::class, 'index']);
