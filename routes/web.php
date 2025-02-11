<?php

use App\Http\Controllers\AtkController;
use App\Http\Controllers\LocotrackController;
use App\Http\Controllers\PidsController;
use App\Http\Controllers\UpsController;
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
use App\Http\Controllers\BarangMasukController;

Route::get('/', function () {
    return view('login');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

Route::get('/katalog/sparepart', [SparepartController::class, 'index'])->name('sparepart.index');
Route::post('/katalog/sparepart/store', [SparepartController::class, 'store'])->name('sparepart.store');
Route::put('/katalog/spareparts/{id}', [SparepartController::class, 'update'])->name('spareparts.update');
Route::delete('/katalog/spareparts/{id}', [SparepartController::class, 'destroy'])->name('spareparts.destroy');

Route::get('/katalog/toolkit', [ToolKitController::class, 'index'])->name('toolkit.index');
Route::post('/katalog/toolkit/store', [ToolKitController::class, 'store'])->name('toolkits.store');
Route::put('/katalog/toolkit/{id}', [ToolKitController::class, 'update'])->name('toolkits.update');
Route::delete('/katalog/toolkit/{id}', [ToolKitController::class, 'destroy'])->name('toolkits.destroy');

Route::get('/katalog/network', [NetworkController::class, 'index'])->name('network.index');
Route::post('/katalog/network/store', [NetworkController::class, 'store'])->name('network.store');
Route::put('/katalog/networks/{id}', [NetworkController::class, 'update'])->name('networks.update');
Route::delete('/katalog/networks/{id}', [NetworkController::class, 'destroy'])->name('networks.destroy');

Route::get('/katalog/cctv', [CctvController::class, 'index'])->name('cctv.index');
Route::post('/katalog/cctv/store', [CctvController::class, 'store'])->name('cctv.store');
Route::put('/katalog/cctvs/{id}', [CctvController::class, 'update'])->name('cctvs.update');
Route::delete('/katalog/cctvs/{id}', [CctvController::class, 'destroy'])->name('cctvs.destroy');

Route::get('/katalog/tabletmonitor', [TabletMonitorController::class, 'index'])->name('tabletmonitor.index');
Route::post('/katalog/tabletmonitor/store', [TabletMonitorController::class, 'store'])->name('tabletmonitor.store');
Route::put('/katalog/tabletmonitors/{id}', [TabletMonitorController::class, 'update'])->name('tabletmonitors.update');
Route::delete('/katalog/tabletmonitors/{id}', [TabletMonitorController::class, 'destroy'])->name('tabletmonitors.destroy');

Route::get('/katalog/webcam', [WebcamController::class, 'index'])->name('webcam.index');
Route::post('/katalog/webcam/store', [WebcamController::class, 'store'])->name('webcam.store');
Route::put('/katalog/webcams/{id}', [WebcamController::class, 'update'])->name('webcams.update');
Route::delete('/katalog/webcams/{id}', [WebcamController::class, 'destroy'])->name('webcams.destroy');

Route::get('/katalog/pclaptop', [PCLapController::class, 'index'])->name('pclaptop.index');
Route::post('/katalog/pclaptop/store', [PCLapController::class, 'store'])->name('pclaptop.store');
Route::put('/katalog/pclaptops/{id}', [PCLapController::class, 'update'])->name('pclaptops.update');
Route::delete('/katalog/pclaptops/{id}', [PCLapController::class, 'destroy'])->name('pclaptops.destroy');

Route::get('/katalog/printer', [PrinterController::class, 'index'])->name('printer.index');
Route::post('/katalog/printer/store', [PrinterController::class, 'store'])->name('printer.store');
Route::put('/katalog/printers/{id}', [PrinterController::class, 'update'])->name('printers.update');
Route::delete('/katalog/printers/{id}', [PrinterController::class, 'destroy'])->name('printers.destroy');

Route::get('/katalog/pids', [PidsController::class, 'index'])->name('pids.index');
Route::post('/katalog/pids/store', [PidsController::class, 'store'])->name('pids.store');
Route::put('/katalog/pidss/{id}', [PidsController::class, 'update'])->name('pidss.update');
Route::delete('/katalog/pidss/{id}', [PidsController::class, 'destroy'])->name('pidss.destroy');

Route::get('/katalog/locotrack', [LocotrackController::class, 'index'])->name('locotrack.index');
Route::post('/katalog/locotrack/store', [LocotrackController::class, 'store'])->name('locotrack.store');
Route::put('/katalog/locotracks/{id}', [LocotrackController::class, 'update'])->name('locotracks.update');
Route::delete('/katalog/locotracks/{id}', [LocotrackController::class, 'destroy'])->name('locotracks.destroy');

Route::get('/katalog/atk', [AtkController::class, 'index'])->name('atk.index');
Route::post('/katalog/atk/store', [AtkController::class, 'store'])->name('atk.store');
Route::put('/katalog/atks/{id}', [AtkController::class, 'update'])->name('atks.update');
Route::delete('/katalog/atks/{id}', [AtkController::class, 'destroy'])->name('atks.destroy');

Route::get('/katalog/ups', [UpsController::class, 'index'])->name('ups.index');
Route::post('/katalog/ups/store', [UpsController::class, 'store'])->name('ups.store');
Route::put('/katalog/upss/{id}', [UpsController::class, 'update'])->name('upss.update');
Route::delete('/katalog/upss/{id}', [UpsController::class, 'destroy'])->name('upss.destroy');

Route::get('/transaksi/barang-masuk', [BarangMasukController::class, 'index'])->name('barang_masuk.index');
Route::post('/transaksi/barang-masuk', [BarangMasukController::class, 'store'])->name('barang_masuk.store');
