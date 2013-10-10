<?php

class CheckRequest extends Eloquent
{
	protected $softDelete = true;
	protected $table = 'requests';
	protected $fillable = array('site_id', 'http_status', 'response_time');
}
