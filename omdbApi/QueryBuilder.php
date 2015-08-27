<?php namespace Jtaurus\OmdbApi;

use Jtaurus\OmdbApi\UnrecognizedApiParameterName;
use Jtaurus\OmdbApi\InvalidParameterValue;

class QueryBuilder{
	
	public static $apiHost = "http://www.omdbapi.com/";

	public static $arrayOfAllowedParameters = array("s",
		"i", "t", "type", "y", "plot", "r", "tomatoes", "callback", "v");

	public static $arrayOfAllowedParameterValues = array(
		"type" => array("movie", "series", "episode"),
		"plot" => array("short", "full"),
		"r" => array("json", "xml"),
		"tomatoes" => array("true", "false"));

	public static $arrayOfDefaultParameterValues = array(
			"r" => "json");

	public function __construct()
	{

	}
	/*
		Create an url of hostname + api parameters or throw an exception
	*/

	public static function create($arrayOfParameters)
	{
		return self::$apiHost . self::serialize_parameters($arrayOfParameters);
	}

	/*
		@param - array of parameters - key->value - key - parameter name, value - parameter value
		@return - string - created URL
	*/
	public static function serialize_parameters($arrayOfParamaters)
	{
		$arrayOfParamaters = self::addRequiredParameters($arrayOfParamaters);
		$urlParameters = "?";
		foreach($arrayOfParamaters as $key => $value)
		{
			if(!self::checkIfParameterRecognized($key))
			{
				throw new UnrecognizedApiParameterName("Unrecognized parameter name: " . $key . " supplied.");
			}
			if(!self::checkIfParameterContainsAllowedValue($key,$value))
			{
				throw new InvalidParameterValue("Parameter: " . $key . " contains invalid value of: " . $value);
			}
			$urlParameters .=  $key . '=' . $value . '&';
		}
		return rtrim($urlParameters, '&');
	}

	public static function checkIfParameterRecognized($parameterName)
	{
		return in_array($parameterName, self::$arrayOfAllowedParameters);
	}

	public static function checkIfParameterContainsAllowedValue($parameterName, $parameterValue)
	{
		if(array_key_exists($parameterName, self::$arrayOfAllowedParameterValues))
		{
			if(!in_array($parameterValue, self::$arrayOfAllowedParameterValues[$parameterName]))
			{
				return false;
			}
		}
		return true;
	}

	public static function addRequiredParameters($paramArray)
	{
		foreach(self::$arrayOfDefaultParameterValues as $key => $value)
		{
			if(!array_key_exists($key, $paramArray))
			{
				$paramArray[$key] = $value;
			}
		}
		return $paramArray;
	}

	public static function getDefaultParameterValue($paramName)
	{
		return self::$arrayOfDefaultParameterValues[$paramName];
	}

}