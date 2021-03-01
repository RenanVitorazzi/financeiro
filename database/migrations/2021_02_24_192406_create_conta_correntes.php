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
        Schema::create('contas_correntes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->enum('balanco', ['Débito', 'Crédito']);
            $table->decimal('peso', 8, 2);
            $table->longText('observacao')->nullable();
            $table->decimal('cotacao', 8, 2)->nullable();
            $table->foreignId('fornecedor_id')->constrained('fornecedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contas_correntes');
    }
}
