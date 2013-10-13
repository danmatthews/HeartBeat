<?php

class DatabaseSeeder extends Seeder {

	public $sites;

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->sites = Config::get('sites');
		Eloquent::unguard();
		foreach ($this->sites as $server => $sites) {
			$newServer = new Server(array('name' => $server));
			$newServer->save();
			foreach ($sites as $name => $url) {
				$newSite = new Site(array('name' => $name, 'url' => $url));
				$newServer->sites()->save($newSite);
			}
		}
	}

}
