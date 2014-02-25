<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('properties', function($table){

			$table->increments('id');
			$table->string('title')
					->nullable()
					->default(null);
			$table->foreign('operation_id')
					->unsigned()
					->references('id')->on('operations');
			$table->foreign('inmueble_id')
					->unsigned()
					->references('id')->on('inmuebles');
			$table->float('price')
					->
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
		//
	}

}
