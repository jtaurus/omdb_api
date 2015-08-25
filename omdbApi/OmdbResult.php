<?php namespace Jtaurus\OmdbApi;

use Jtaurus\OmdbApi\UnrecognizedDataStructureReturnedByApi;
use Jtaurus\OmdbApi\AbstractResultParser;
use Exception;

class OmdbResult extends AbstractResultParser{

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

		if($this->isJson($apiResponseBlob)){
			$this->jsonData = $apiResponseBlob;
			$this->convertJsonToArray();
		}

		else if($this->isXml($apiResponseBlob)){
			$this->xmlData = $apiResponseBlob;
			$this->convertXmlToArray();
			$this->dataAsArray = $this->reshapeArrayComingFromXml($this->dataAsArray);
		}
		else{
			throw new UnrecognizedDataStructureReturnedByApi("Api did not return JSON nor XML.");
		}
		$this->parseResponseMetaData();
		$this->parseBasicData();
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