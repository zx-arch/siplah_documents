<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembatalanTransaksiModel;
use Illuminate\Support\Facades\Session;

class TrashController extends Controller
{
    public function index()
    {
        if (Session::has('status_login')) {
            $checkdocument = PembatalanTransaksiModel::onlyTrashed()->take(75)->get();
            // dd($checkdocument);
            return view('documents.trash', [
                'checkdocument' => $checkdocument
            ]);
        } else {
            return redirect('/login');
        }
    }

    public function deletePermanent($id, $kode_document)
    {
        if (Session::has('status_login')) {
            $delete = PembatalanTransaksiModel::deletePermanent($id, $kode_document);

            if ($delete == 1) {
                return redirect('/trash')->with('delete_document_success', 'Document ' . $kode_document . ' berhasil dihapus');
            }
        } else {
            return redirect('/login');
        }
    }

    public function restore(Request $request)
    {
        if (Session::has('status_login')) {
            $restore = PembatalanTransaksiModel::restore($request->id, $request->kode_document);
            //dd($restore);
            if ($restore == 1) {
                return redirect('/pembatalan_transaksi')->with('restore_document_success', 'Document ' . $request->kode_document . ' berhasil dipulihkan');
            }
        } else {
            return redirect('/login');
        }
    }
}