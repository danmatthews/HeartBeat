<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{

	$servers = Server::limit(10)->get();

	$tweets = Tweet::limit(5)->get()->toArray();

	foreach($tweets as $key => $tweet) {
		$t = unserialize($tweet['tweet_data']);
		$t->timestamp = $tweet['twitter_timestamp'];
		$tweets[$key] = $t;
	}

	return View::make('app', array(
		'input' => Input::all(),
		'tweets' => $tweets,
		'servers' => $servers,
	));
});

Route::get('servers', function() {
	return (DB::select(
		"SELECT srv.name,
		srv.id,
		IF ((SELECT count(*) FROM requests r WHERE r.http_status != 200 AND r.http_status > 0 AND r.deleted_at IS NULL AND r.site_id IN (SELECT s.id FROM sites s WHERE s.server_id = srv.id)) > 0, 'error', 'okay') as 'alert_status',
		IF ((SELECT count(*) FROM requests r WHERE r.http_status != 200 AND r.http_status > 0 AND r.deleted_at IS NULL AND r.site_id IN (SELECT s.id FROM sites s WHERE s.server_id = srv.id)) > 0, 'Functioning with errors', 'Functioning normally') as 'alert_text'
		   FROM servers srv
		   ORDER BY alert_status ASC, srv.name ASC
	      LIMIT 10")
	);
});

Route::get('tweets', function(){
	if (Cache::has('tweets'))
	{
	    $tweets = Cache::get('tweets');
	} else {
		$tweets = Twitter::getSearch(array('q' => 'teamhydrant' ,'count' => 5));
	    Cache::add('tweets', $tweets, 15);
	}
	return (array)$tweets->statuses;
});

Route::get('tweetup', function(){
	return View::make('tweetup');
});

Route::get('tweetuptweets', function() {
	if (Cache::has('tweetuptweets'))
	{
	    $tweets = Cache::get('tweetuptweets');
	} else {
		$tweets = Twitter::getSearch(array('q' => 'carlisletweetup' ,'count' => 5));
	    Cache::add('tweetuptweets', $tweets, 3);
	}
	return (array)$tweets->statuses;
});
