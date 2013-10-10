<?php

class Site extends Eloquent {

	public function server()
	{
		return $this->belongsTo('Server');
	}
}
