<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MovimentacoesCheques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentacoes_cheques', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->integer('motivo');
            $table->enum('status', ['Devolvido', 'Aguardando', 'Pago', 'Resgatado']);
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
        Schema::dropIfExists('movimentacoes_cheques');
    }
}
