<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDevolvidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolvidos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('data_pagamento');
            $table->decimal('valor', 10, 2);
            $table->text('observacao')->nullable();
            $table->integer('motivo');
            $table->integer('motivo_2')->nullable();
            $table->boolean('pago')->default(0);
            $table->foreignId('parcela_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devolvidos');
    }
}
