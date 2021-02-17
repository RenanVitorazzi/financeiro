<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('situacao')->nullable();
            $table->integer('pessoa_id');
            $table->timestamps();
            $table->integer('representante_id')->nullable();
            $table->foreign('pessoa_id')
                ->references('id')
                ->on('pessoas');

            $table->foreign('representante_id')
                ->references('id')
                ->on('representantes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
