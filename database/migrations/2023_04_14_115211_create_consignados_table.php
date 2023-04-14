<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsignadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignados', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->date('data');
            $table->dateTime('baixado')->nullable();
            $table->decimal('fator', 10, 2)->nullable();
            $table->decimal('peso', 11, 3)->nullable();
            $table->foreignId('representante_id')->constrained('representantes');
            $table->foreignId('venda_id')->nullable()->constrained('vendas');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->longText('observacao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consignados');
    }
}
