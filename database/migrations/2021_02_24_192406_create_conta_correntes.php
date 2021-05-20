<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaCorrentes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta_corrente', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->date('data')->nullable();
            $table->enum('balanco', ['Débito', 'Crédito']);
            $table->decimal('peso', 8, 3)->nullable();
            $table->decimal('valor', 8, 2)->nullable();
            $table->decimal('cotacao', 8, 2)->nullable();
            $table->longText('observacao')->nullable();
            $table->foreignId('fornecedor_id')->constrained('fornecedores');
            $table->decimal('peso_agregado', 8, 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conta_corrente');
    }
}
