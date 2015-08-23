<?php namespace Jtaurus\OmdbApi;

use  Jtaurus\OmdbApi\UnrecognizedApiParameterName;

class QueryBuilder{
	
	public static $apiHost = "http://www.omdbapi.com/";
	public static $arrayOfAllowedParameters = array("s",
		"i", "t", "type", "y", "plot", "r", "tomatoes", "callback", "v");

	public function __construct(){
	}
	/*
		Create an url of hostname + api parameters or throw an exception
	*/

	public static function create($arrayOfParameters){
		return self::$apiHost . self::serialize_parameters($arrayOfParameters);
	}

	/*
		@param - array of parameters - key->value - key - parameter name, value - parameter value
		@return - string - created URL
	*/
	public static function serialize_parameters($arrayOfParamaters){
		//http://www.omdbapi.com/?t=lol&y=&plot=short&r=json
		$urlParameters = "?";
		foreach($arrayOfParamaters as $key => $value){
			if(!self::checkIfParameterRecognized($key)){
				throw new UnrecognizedApiParameterName("Unrecognized parameter supplied.");
			}
			$urlParameters .=  $key . '=' . $value . '&';
		}
		return rtrim($urlParameters, '&');
	}

	public static function checkIfParameterRecognized($parameterName){
		return in_array($parameterName, self::$arrayOfAllowedParameters);
	}

}