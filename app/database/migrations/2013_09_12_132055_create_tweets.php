<?php

use Illuminate\Database\Migrations\Migration;

class CreateTweets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tweets', function($table)
		{
			$table->increments('id');
			$table->text('tweet_data');
			$table->dateTime('twitter_timestamp');
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
		Schema::dropIfExists('tweets');
	}

}
