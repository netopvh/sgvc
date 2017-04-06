<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enum\TipoPessoa;
use App\Enum\Status;

class CreateEmpresasTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empresas', function(Blueprint $table) {
            $table->increments('id');
			$table->string('razao');
			$table->string('fantasia')->nullable();
			$table->string('cpf_cnpj');
			$table->enum('tipo_pessoa',TipoPessoa::getKeys());
			$table->string('responsavel')->nullable();;
			$table->string('email')->nullable();
			$table->enum('status',Status::getKeys())->default('A');
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
		Schema::drop('empresas');
	}

}
