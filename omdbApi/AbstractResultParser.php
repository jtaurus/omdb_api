<?php namespace Jtaurus\OmdbApi;

use Jtaurus\OmdbApi\UnrecognizedDataStructureReturnedByApi;
use Exception;

abstract class AbstractResultParser
{
	
	protected $apiResponseBlob;
	protected $jsonData;
	protected $xmlData;
	protected $dataAsArray;

	public function convertJsonToArray(){
		$this->dataAsArray = $this->convertAllArrayKeysToLowerCase(json_decode($this->jsonData, true), CASE_LOWER);
	}

	public function convertXmlToArray(){
		$loadedXml = simplexml_load_string($this->apiResponseBlob);
		$asJson = json_encode($loadedXml);
		$this->dataAsArray = $this->convertAllArrayKeysToLowerCase(json_decode($asJson, true));
	}

	protected function convertAllArrayKeysToLowerCase($array){
		return array_map(function ($oneValue){
			if(is_array($oneValue)){
				$oneValue = $this->convertAllArrayKeysToLowerCase($oneValue);
			}
			return $oneValue;
		}, array_change_key_case($array, CASE_LOWER));
	}

	// We are reshaping the array provided from XML conversion.
	// Its structure will be the same as the one coming from JSON response.

	public function reshapeArrayComingFromXml($array){
		$newArray = array();
		foreach($array as $oneKey => $oneValue){
			if(is_array($oneValue)){
				$newArray = array_merge($newArray, $this->reshapeArrayComingFromXml($oneValue));
			}
			else{
				$newArray[$oneKey] = $oneValue;
			}
		}
		return $newArray;
	}

	public function isJson($data){
		if( json_decode($data) == NULL){
			return false;
		}
		else{
			return true;
		}
	}

	public function isXml($data){
			try{
				if(simplexml_load_string($data) === false)
				{
					return false;
				}
				else
				{
					return true;
				}
			}
			catch(Exception $e)
			{
				return false;
			}
	}

	public function getJson(){
		return $this->jsonData;
	}

	public function getAssocArray(){
		return $this->dataAsArray;
	}

	public function getErrorMessage(){
		return $this->errorMessage;
	}

	public function getResponseStatus(){
		return $this->responseSuccessful;
	}

	protected function parseResponseMetaData(){
		$this->responseSuccessful = (isset($this->dataAsArray["response"]) && $this->dataAsArray["response"] == "True") ? true : false;
		$this->errorMessage = (isset($this->dataAsArray["error"])) ? $this->dataAsArray["error"] : null;
	}

}