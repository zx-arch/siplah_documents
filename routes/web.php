<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembatalanTransaksiController;
use App\Http\Controllers\TrashController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('documents.home');
});

Route::get('/pembatalan_transaksi', [PembatalanTransaksiController::class, 'index']);
Route::post('/pembatalan_transaksi/download', [PembatalanTransaksiController::class, 'download']);
Route::post('/pembatalan_transaksi/upload/surat_pembatalan_transaksi', [PembatalanTransaksiController::class, 'upload']);
Route::post('pembatalan_transaksi/download_document_upload', [PembatalanTransaksiController::class, 'DownloadDocumentUpload']);
Route::get('pembatalan_transaksi/delete/{user}/{kode_document}', [PembatalanTransaksiController::class, 'deleteTemporary']);

Route::get('trash', [TrashController::class, 'index']);
Route::get('trash/delete/{user}/{kode_document}', [TrashController::class, 'deletePermanent']);
Route::post('trash/restore', [TrashController::class, 'restore']);