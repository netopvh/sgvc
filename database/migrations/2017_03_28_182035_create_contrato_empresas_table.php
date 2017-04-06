<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratoEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato_empresas', function (Blueprint $table) {
            $table->integer('contrato_id')->unsigned();
            $table->integer('empresa_id')->unsigned();

            $table->foreign('contrato_id')->references('id')->on('contratos');
            $table->foreign('empresa_id')->references('id')->on('empresas');

            $table->primary(['contrato_id', 'empresa_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrato_empresas');
    }
}
