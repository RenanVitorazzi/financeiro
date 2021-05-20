<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContaCorrenteAnexos extends Migration
{
    public function up()
    {
        Schema::create('conta_corrente_anexos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('path');
            $table->foreignId('conta_corrente_id')->constrained('conta_corrente');
        });
    }

    public function down()
    {
        Schema::dropIfExists('conta_corrente_anexos');
    }
}
