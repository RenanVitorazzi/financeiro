<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Despesa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locais', function (Blueprint $table) {
            $table->id();
            $table->string('nome');    
        });
        
        Schema::create('despesas_fixas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_quitacao');
            $table->integer('dia_vencimento')->nullable();
            $table->decimal('valor', 8, 2);
            $table->text('observacao')->nullable();  
            $table->unsignedBigInteger('local_id');  
            // $table->foreignId('local_id')->constrained('locais');    
            $table->foreign('local_id')->references('id')->on('locais');    
        });

        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_vencimento');
            $table->date('data_referencia')->nullable();
            $table->decimal('valor', 8, 2);
            $table->text('observacao')->nullable();
            $table->unsignedBigInteger('local_id');
            $table->unsignedBigInteger('fixas_id');
            // $table->foreignId('local_id')->constrained('locais');
            $table->foreign('local_id')->references('id')->on('locais');  
            //$table->foreignId('fixas_id')->constrained('fixas')->nullable();    
            $table->foreign('fixas_id')->references('id')->on('despesas_fixas')->nullable();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('despesas');
        Schema::dropIfExists('despesas_fixas');
        Schema::dropIfExists('locais');
    }
}
