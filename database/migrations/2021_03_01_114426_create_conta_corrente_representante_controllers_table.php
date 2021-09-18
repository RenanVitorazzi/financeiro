<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaCorrenteRepresentanteControllersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta_corrente_representante', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->date('data');
            $table->enum('balanco', ['Reposição', 'Venda', 'Devolução']);
            $table->decimal('fator', 10, 2);
            $table->decimal('peso', 11, 3);
            $table->decimal('fator_agregado', 10, 2);
            $table->decimal('peso_agregado', 11, 3);
            $table->foreignId('representante_id')->constrained('representantes');
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
        Schema::dropIfExists('conta_corrente_representante');
    }
}
