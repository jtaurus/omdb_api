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
		$this->jsonData = $apiResponseBlob;
		$this->convertJsonToArray();
		$this->parseResponseMetaData();
		$this->parseBasicData();
	}

	public function convertJsonToArray(){
		$this->dataAsArray = json_decode($this->jsonData, true);
	}

	public function isJson(){
		if( json_decode($this->apiResponseBlob) == NULL){
			return false;
		}
		else{
			return true;
		}
	}

	public function getJson(){
		return $this->jsonData;
	}

	public function getAssocArray(){
		return $this->dataAsArray;
	}

	protected function parseResponseMetaData(){
		$this->responseSuccessful = (isset($this->dataAsArray["Response"]) && $this->dataAsArray["Response"] == "True") ? true : false;
		$this->errorMessage = (isset($this->dataAsArray["Error"])) ? $this->dataAsArray["Error"] : null;
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

		$this->title = empty($this->dataAsArray["Title"]) ? NULL :$this->dataAsArray["Title"];
	}
	protected function parseYear()
	{
		$this->year = empty($this->dataAsArray["Year"]) ? NULL :$this->dataAsArray["Year"];

	}
	protected function parseRated()
	{
		$this->rated = empty($this->dataAsArray["Rated"]) ? NULL :$this->dataAsArray["Rated"];

	}
	protected function parseReleased()
	{
		$this->released = empty($this->dataAsArray["Released"]) ? NULL :$this->dataAsArray["Released"];

	}
	protected function parseRuntime()
	{
		$this->runtime = empty($this->dataAsArray["Runtime"]) ? NULL :$this->dataAsArray["Runtime"];

	}
	protected function parseGenre()
	{
		$this->genre = empty($this->dataAsArray["Genre"]) ? NULL :$this->dataAsArray["Genre"];
	}
}