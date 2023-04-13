<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PagamentosParceiros extends Migration
{
    /**
     * Run the migrations. 
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagamentos_parceiros', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->date('data')->nullable();
            $table->decimal('valor', 10, 2)->nullable();
            $table->longText('observacao')->nullable();
            $table->foreignId('parceiro_id')->constrained('parceiros');
            $table->foreignId('parcela_id')->constrained('parcelas');
            $table->boolean('baixado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagamentos_parceiros');
    }
}
