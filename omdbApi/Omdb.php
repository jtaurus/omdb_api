<?php namespace Jtaurus\OmdbApi;

use Illuminate\Support\Facades\Facade;

class Omdb extends Facade{
	protected static function getFacadeAccessor()
	{
		return "OmdbApi";
	}
}