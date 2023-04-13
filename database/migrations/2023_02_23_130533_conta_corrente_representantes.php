<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContaCorrenteRepresentantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('parcelas_representantes', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        //     $table->boolean('entregue_representante')->nullable();
        //     $table->enum('representante_status', ['Devolvido', 'Resgatado']);
        //     $table->foreignId('parcela_id')->nullable()->constrained('parcelas');
        // });

        Schema::create('contas', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_banco')->nullable();
            $table->char('agencia', 100)->nullable();
            $table->char('conta', 100)->nullable();
            $table->enum('conta_corrente', ['Conta Corrente', 'Poupança'])->nullable();
            $table->char('nome', 100);
            $table->char('pix', 100)->nullable();
        });

        Schema::create('pagamentos_representantes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->date('data');
            $table->decimal('valor', 10, 2);
            $table->longText('observacao')->nullable();
            $table->foreignId('representante_id')->constrained('representantes');
            $table->foreignId('conta_id')->nullable()->constrained('contas');
            $table->foreignId('parcela_id')->nullable()->constrained('parcelas');
            $table->boolean('baixado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcelas_representantes');
        Schema::dropIfExists('contas');
        Schema::dropIfExists('pagamentos_representantes');
    }
}
