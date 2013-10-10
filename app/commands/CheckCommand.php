<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Guzzle\Http\Client;

class CheckCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'check';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Check sites in the `sites` table for their status.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$servers = Server::all();

		foreach ($servers as $server) {

			$this->info("Checking server named '{$server->name}'...");

			foreach ($server->sites as $site) {

				$this->info("Checking site with URL '{$site->url}'");

				$client = new Client();

				$client->setUserAgent('Hydrant HTTP Statusboard');

				$request = $client->get($site->url);

				try {
					$result = $client->send($request);
					$info = $result->getInfo();
					$http_code = $info['http_code'];
					$total_time = $info['total_time'];
				}
				catch (Guzzle\Http\Exception\CurlException $e) {
					$http_code = $e->getCode() == 0 ? 404 : $e->getCode();
					$methods = get_class_methods($e);
				}

				if ($http_code == 200) {

					$this->info("CHECK SUCCESSFUL");

				} else {

					$this->error("ERROR | {http status: {$http_code}");

				}

				$this->info("HTTP CODE: {$http_code}");

				// Get the previous requests for this site.
				$lastRequest = CheckRequest::where('site_id', $site->id)->first();

				// Check if it was an errenous request.
				if ((empty($lastRequest) || $lastRequest->http_status == 200) && $http_code != 200) {

					// Send an email.
					if ($this->inBusinessHours()) {
						$this->error('Attempting to send an email to notify carlisle@hydrant.co.uk.');
						Mail::send(
							'emails.site_down',
							array('site' => $site, 'date' => date("jS F Y : H:i:s")),
							function($message) {
								$message->to('carlisle@hydrant.co.uk')->subject('Site Down!');
							}
						);
					}

				} elseif (!empty($lastRequest) && $lastRequest->http_status != 200 && $http_code == 200) {
					// Back Up! Send an email HOORAY.
					Mail::send(
						'emails.site_up',
						array('site' => $site, 'date' => date("jS F Y : H:i:s")),
						function($message) {
							$message->to('carlisle@hydrant.co.uk')->subject('Site Back Up!');
						}
					);
				}

				if ($lastRequest instanceof CheckRequest) {
					$lastRequest->delete();
				}

				$request = new CheckRequest(array(
					'site_id' => $site->id,
					'http_status' => (int)$http_code,
					'response_time' => (float)$total_time,
				));

				$request->save();
			}
			$this->comment('------------');
		}

	}

	/**
	 * Determine if now() falls within business hours.
	 * @return bool
	 */
	public function inBusinessHours()
	{
		$timeNow = time();

		// Create two boundary timestamps for today.
		$open = mktime(9, 0);
		$close = mktime(19, 30);

		// Is the current time between these two times?
		if ($timeNow > $open && $timeNow < $close) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

}
