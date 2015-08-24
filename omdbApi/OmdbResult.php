<?php namespace Jtaurus\OmdbApi;


class OmdbResult{

	protected $apiResponseBlob;
	protected $jsonData;
	protected $xmlData;
	protected $dataAsArray;

	// Response data:
	protected $responseSuccessful;
	protected $errorMessage;

	// Movie data:
	protected $title;
	protected $year;
	protected $rated;
	protected $released;
	protected $runtime;
	protected $genre;

	public function __construct($apiResponseBlob){
		$this->apiResponseBlob = $apiResponseBlob;

		if($this->isJson()){
			$this->jsonData = $apiResponseBlob;
			$this->convertJsonToArray();
		}

		else if($this->isXml()){
			$this->xmlData = $apiResponseBlob;
			$this->convertXmlToArray();
			$this->dataAsArray = $this->reshapeArrayComingFromXml($this->dataAsArray);
		}
		$this->parseResponseMetaData();
		$this->parseBasicData();
	}

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

	public function isJson(){
		if( json_decode($this->apiResponseBlob) == NULL){
			return false;
		}
		else{
			return true;
		}
	}

	public function isXml(){
		if(simplexml_load_string($this->apiResponseBlob === false))
		{
			return false;
		}
		else
		{
			return true;
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

	public function getTitle(){
		return $this->title;
	}

	public function getYear(){
		return $this->year;
	}

	public function getRated(){
		return $this->rated;
	}

	public function getReleased(){
		return $this->released;
	}

	public function getRuntime(){
		return $this->runtime;
	}

	public function getGenre(){
		return $this->genre;
	}

	protected function parseResponseMetaData(){
		$this->responseSuccessful = (isset($this->dataAsArray["response"]) && $this->dataAsArray["response"] == "True") ? true : false;
		$this->errorMessage = (isset($this->dataAsArray["error"])) ? $this->dataAsArray["error"] : null;
	}

	protected function parseBasicData(){
		$this->parseTitle();
		$this->parseYear();
		$this->parseRated();
		$this->parseReleased();
		$this->parseRuntime();
		$this->parseGenre();

	}

	protected function parseTitle()
	{

		$this->title = empty($this->dataAsArray["title"]) ? NULL :$this->dataAsArray["title"];
	}
	protected function parseYear()
	{
		$this->year = empty($this->dataAsArray["year"]) ? NULL :$this->dataAsArray["year"];

	}
	protected function parseRated()
	{
		$this->rated = empty($this->dataAsArray["rated"]) ? NULL :$this->dataAsArray["rated"];

	}
	protected function parseReleased()
	{
		$this->released = empty($this->dataAsArray["released"]) ? NULL :$this->dataAsArray["released"];

	}
	protected function parseRuntime()
	{
		$this->runtime = empty($this->dataAsArray["runtime"]) ? NULL :$this->dataAsArray["runtime"];

	}
	protected function parseGenre()
	{
		$this->genre = empty($this->dataAsArray["genre"]) ? NULL :$this->dataAsArray["genre"];
	}
}