<?php

class Server extends Eloquent {
	public function sites()
	{
		return $this->hasMany('Site');
	}
}
