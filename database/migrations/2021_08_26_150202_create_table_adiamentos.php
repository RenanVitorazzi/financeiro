<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAdiamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adiamentos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('nova_data');
            $table->float('taxa_juros');
            $table->decimal('juros_totais', 8, 2);
            $table->integer('dias_totais');
            $table->text('observacao');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adiamentos');
    }
}
