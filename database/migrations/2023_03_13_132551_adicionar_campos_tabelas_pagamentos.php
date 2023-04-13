<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdicionarCamposTabelasPagamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pagamentos_parceiros', function (Blueprint $table) {
            $table->foreignId('conta_id')->nullable()->constrained('contas');
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('confirmado');
            $table->longText('comprovante_id')->nullable();
            $table->enum('forma_pagamento', ['Dinheiro', 'Cheque', 'Cartão de Crédito', 'Cartão de Débito', 'Depósito', 'Boleto', 'TED', 'DOC']);
        });

        Schema::table('pagamentos_representantes', function (Blueprint $table) {
            $table->foreignId('conta_id')->nullable()->constrained('contas');
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('confirmado');
            $table->longText('comprovante_id')->nullable();
            $table->enum('forma_pagamento', ['Dinheiro', 'Cheque', 'Cartão de Crédito', 'Cartão de Débito', 'Depósito', 'Boleto', 'TED', 'DOC']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
