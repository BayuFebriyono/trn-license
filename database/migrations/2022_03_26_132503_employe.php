<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Employe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string('nik',6);
            $table->string('nama');
            $table->string('section',20);
            $table->string('carline',100);
            $table->string('carcode');
            $table->string('line');
            $table->char('shift');
            $table->string('lokasi',8);
            $table->string('expired_date');
            $table->integer('month_expired');
            $table->date('tanggal_tes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employes');
    }
}
