<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TrocaAdiamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('troca_adiamentos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->date('data');
            $table->float('dias_totais');
            $table->decimal('adicional_juros', 10, 2);
            $table->decimal('juros_totais', 10, 2);
            $table->decimal('taxa', 10, 2);
            $table->longText('observacao')->nullable();
            $table->foreignId('troca_parcela_id')->constrained('trocas_parcelas');
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
        Schema::dropIfExists('troca_adiamentos');
    }
}
