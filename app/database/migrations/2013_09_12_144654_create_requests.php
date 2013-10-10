<?php

use Illuminate\Database\Migrations\Migration;

class CreateRequests extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('requests', function($table)
		{
			$table->increments('id');
			$table->integer('site_id')->unsigned();
			$table->float('response_time');
			$table->integer('http_status');
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
		Schema::drop('requests');
	}

}
