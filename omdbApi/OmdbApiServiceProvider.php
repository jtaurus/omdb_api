<?php namespace Jtaurus\OmdbApi;

use Illuminate\Support\ServiceProvider;

class OmdbApiServiceProvider extends ServiceProvider{
	

	public function register(){
		$this->app->bind("OmdbApi", function(){
			return new OmdbApi();
			});
	}
}