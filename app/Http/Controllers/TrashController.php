<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembatalanTransaksiModel;

class TrashController extends Controller
{
    public function index()
    {
        $checkdocument = PembatalanTransaksiModel::onlyTrashed()->take(75)->get();
        // dd($checkdocument);
        return view('documents.trash', [
            'checkdocument' => $checkdocument
        ]);
    }

    public function deletePermanent($id, $kode_document)
    {
        $delete = PembatalanTransaksiModel::deletePermanent($id, $kode_document);

        if ($delete == 1) {
            return redirect('/trash')->with('delete_document_success', 'Document ' . $kode_document . ' berhasil dihapus');
        }
    }

    public function restore(Request $request)
    {
        $restore = PembatalanTransaksiModel::restore($request->id, $request->kode_document);
        //dd($restore);
        if ($restore == 1) {
            return redirect('/pembatalan_transaksi')->with('restore_document_success', 'Document ' . $request->kode_document . ' berhasil dipulihkan');
        }
    }
}