<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembatalanTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembatalan_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('user', 50)->nullable(false);
            $table->string('kode_document', 20)->nullable(false);
            $table->string('nama_document', 100)->nullable(false);
            $table->binary('file')->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembatalan_transaksi');
    }
}