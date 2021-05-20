<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->date('data_venda');
            $table->decimal('peso', 8, 3)->nullable();
            $table->decimal('fator', 8, 2)->nullable();
            $table->decimal('cotacao_peso', 8, 2)->nullable();
            $table->decimal('cotacao_fator', 8, 2)->nullable();
            $table->decimal('valor_total', 8, 2)->nullable();
            
            $table->enum('metodo_pagamento', ['À vista', 'Parcelado', 'Aberto', 'Parcelado com entrada'])->nullable();
            $table->longText('observacao')->nullable();
            $table->boolean('enviado_conta_corrente')->nullable();
            $table->foreignId('representante_id')->constrained('representantes');
            $table->foreignId('cliente_id')->constrained('clientes');
        });

        Schema::create('parcelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venda_id')->nullable()->constrained('vendas');
            $table->date('data_parcela');
            $table->string('nome_cheque')->nullable();
            $table->string('numero_cheque')->nullable();
            $table->decimal('valor_parcela', 8, 2);
            $table->enum('forma_pagamento', ['Dinheiro', 'Cheque', 'Nota Promissória', 'Cartão de Crédito', 'Cartão de Débito', 'Transferência Bancária', 'Depósito', 'Boleto', 'Aberto']);
            $table->enum('status', ['Pago', 'Sustado', 'Adiado', 'Aguardando', 'Devolvido', 'Resgatado'])->default('Aguardando');
            $table->string('motivo')->nullable();
            $table->longText('observacao')->nullable();
            $table->foreignId('parceiro_id')->nullable()->constrained('parceiros');
            $table->foreignId('representante_id')->nullable()->constrained('representantes');
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
        Schema::dropIfExists('parcelas');
        Schema::dropIfExists('vendas');
    }
}
