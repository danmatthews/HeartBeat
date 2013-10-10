<?php

use Illuminate\Database\Migrations\Migration;

class CreateDbStructure extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sites', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('url');
			$table->integer('server_id')->unsigned();
			$table->boolean('exclude');
			$table->timestamps();
		});

		Schema::create('servers', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
		});

		Schema::create('server_alerts', function($table)
		{
			$table->increments('id');
			$table->integer('server_id');
			$table->softDeletes();
			$table->timestamps();
		});

		Schema::create('site_alerts', function($table)
		{
			$table->increments('id');
			$table->integer('site_id');
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
		Schema::dropIfExists('sites');
		Schema::dropIfExists('servers');
		Schema::dropIfExists('site_alerts');
		Schema::dropIfExists('server_alerts');
	}

}
