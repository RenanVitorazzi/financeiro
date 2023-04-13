<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TabelaEstoque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estoque', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->date('data')->nullable();
            $table->enum('balanco', ['Débito', 'Crédito']);
            $table->decimal('peso', 11, 3)->nullable();
            $table->decimal('valor', 10, 2)->nullable();
            $table->longText('observacao')->nullable();
            // $table->foreignId('fornecedor_id')->nullable()->constrained('fornecedores');
            // $table->foreignId('representante_id')->nullable()->constrained('representantes');
            $table->decimal('peso_agregado', 11, 3)->nullable();
            $table->decimal('fator_agregado', 10, 2)->nullable();
            $table->foreignId('user_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estoque');
    }
}
