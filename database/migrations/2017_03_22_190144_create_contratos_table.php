<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enum\TipoContrato;

class CreateContratosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contratos', function(Blueprint $table) {
            $table->increments('id');
			$table->enum('tipo',TipoContrato::getKeys());
			$table->string('numero');
			$table->integer('ano');
			$table->string('modalidade',1)->nullable();
			$table->string('tipo_servico')->nullable();
			$table->integer('casa_id')->unsigned();
			$table->foreign('casa_id')->references('id')->on('casas');
			$table->integer('unidade_id')->unsigned()->nullable();
			$table->foreign('unidade_id')->references('id')->on('unidades');
			$table->string('aditivado',1)->default('N');
			$table->string('ambito',1);
			$table->decimal('total',10,2);
			$table->decimal('mensal',10,2)->nullable();
			$table->date('inicio');
			$table->date('encerramento');
			$table->longText('objeto');
			$table->string('arquivo')->nullable();
			$table->string('status',1)->default('V');
			$table->integer('orig_ano')->nullable();
			$table->decimal('orig_total',10,2)->nullable();
			$table->decimal('orig_mensal',10,2)->nullable();
			$table->date('orig_inicio')->nullable();
			$table->date('orig_encerramento')->nullable();
			$table->longText('orig_objeto')->nullable();
			$table->softDeletes();
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contratos');
	}

}
