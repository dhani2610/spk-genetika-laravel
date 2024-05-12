<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedulers', function (Blueprint $table) {
            $table->id();
            $table->integer('id_karyawan');
            $table->string('posisi_w1')->nullable();
            $table->string('posisi_w2')->nullable();
            $table->string('posisi_w3')->nullable();
            $table->string('posisi_w4')->nullable();
            $table->string('off_1')->nullable();
            $table->string('off_2')->nullable();
            $table->integer('id_karyawan_change_off_1')->nullable();
            $table->integer('id_karyawan_change_off_2')->nullable();
            $table->integer('status_off_1')->nullable();
            $table->integer('status_off_2')->nullable();
            $table->string('posisi_before_off_1')->nullable();
            $table->string('posisi_before_off_2')->nullable();
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
        Schema::dropIfExists('schedulers');
    }
}
