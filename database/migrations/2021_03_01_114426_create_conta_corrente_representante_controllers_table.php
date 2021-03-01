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
        Schema::create('conta_corrente_representante_controllers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->decimal('fator', 8, 2);
            $table->decimal('peso', 8, 2);
            $table->date('data');
            $table->enum('balanco', ['Reposição', 'Venda', 'Devolução']);
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
        Schema::dropIfExists('conta_corrente_representante_controllers');
    }
}
