<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembatalanTransaksiModel extends Model
{
    use SoftDeletes;
    protected $table = 'pembatalan_transaksi';
    protected $fillable = [
        'id',
        'kode_document',
        'user',
        'nama_document',
        'file'
    ];
    protected $hidden = [];

    protected static function boot()
    {
        parent::boot();

        // Event creating akan dipanggil sebelum data disimpan ke database
        static::creating(function ($model) {
            // Mengambil nomor urut terakhir + 1
            $lastNumber = static::max('kode_document');
            $number = ($lastNumber) ? (int) str_replace('SKPT-', '', $lastNumber) + 1 : 1;

            // Format kode_document sesuai kebutuhan
            $model->kode_document = 'SKPT-' . $number;
        });
    }

    public static function deleteTemporary($user, $kode_document)
    {
        // Gunakan metode delete untuk menghapus data berdasarkan kondisi
        return static::where('kode_document', $kode_document)
            ->where('user', $user)
            ->delete();
    }

    public static function deletePermanent($id, $kode_document)
    {
        // Gunakan metode delete untuk menghapus data berdasarkan kondisi
        return static::where('kode_document', $kode_document)
            ->where('id', $id)
            ->forceDelete();
    }
    public static function restore($id, $kode_document)
    {
        // Gunakan metode delete untuk menghapus data berdasarkan kondisi
        return static::where('kode_document', $kode_document)
            ->where('id', $id)
            ->restore();
    }
}