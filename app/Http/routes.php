<?php namespace Jtaurus\OmdbApi;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function(){
	$omdbApiInstance = App::make('OmdbApi');
	var_dump($omdbApiInstance->byTitleYear("gone girl", "2014")->getAssocArray());
});
