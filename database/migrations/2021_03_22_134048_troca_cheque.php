<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TrocaCheque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trocas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('titulo')->nullable();
            $table->date('data_troca');
            $table->foreignId('parceiro_id')->nullable()->constrained('parceiros');
            $table->decimal('taxa_juros', 10, 2);
            $table->decimal('valor_bruto', 10, 2)->nullable();
            $table->decimal('valor_liquido', 10, 2)->nullable();
            $table->decimal('valor_juros', 10, 2)->nullable();
            $table->longText('observacao')->nullable();
        });

        Schema::create('trocas_parcelas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('dias');
            $table->decimal('valor_liquido', 10, 2);
            $table->decimal('valor_juros', 10, 2);
            $table->foreignId('parcela_id')->constrained('parcelas');
            $table->foreignId('troca_id')->constrained('trocas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trocas_parcelas');
        Schema::dropIfExists('trocas');
    }
}
