<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();

            $table->string('titulo');
            $table->longText('cuerpo')->nullable();
            $table->string('imagen')->nullable();
            $table->string('desc_imagen')->nullable();
            $table->string('color');
            $table->date('inicio');
            $table->date('fin')->nullable();

            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('set null');


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
        Schema::dropIfExists('eventos');
    }
}
