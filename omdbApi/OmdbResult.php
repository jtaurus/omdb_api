<?php namespace Jtaurus\OmdbApi;

use Jtaurus\OmdbApi\UnrecognizedDataStructureReturnedByApi;
use Jtaurus\OmdbApi\AbstractResultParser;
use Exception;
use Jtaurus\OmdbApi\MovieData;

class OmdbResult extends AbstractResultParser{

	protected $apiResponseBlob;
	protected $jsonData;
	protected $xmlData;
	protected $dataAsArray;

	// Movie data:
	protected $movieDataObject;


	public function __construct($apiResponseBlob){
		$this->handleApiResponse($apiResponseBlob);
		$this->instantiateMovieDataObject();
		$this->parseBasicData();
	}
	protected function instantiateMovieDataObject(){
		$this->movieDataObject = new MovieData();
	}
	public function getTitle(){
		return $this->movieDataObject->title;
	}

	public function getYear(){
		return $this->movieDataObject->year;
	}

	public function getRated(){
		return $this->movieDataObject->rated;
	}

	public function getReleased(){
		return $this->movieDataObject->released;
	}

	public function getRuntime(){
		return $this->movieDataObject->runtime;
	}

	public function getGenre(){
		return $this->movieDataObject->genre;
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

		$this->movieDataObject->title = empty($this->dataAsArray["title"]) ? NULL :$this->dataAsArray["title"];
	}
	protected function parseYear()
	{
		$this->movieDataObject->year = empty($this->dataAsArray["year"]) ? NULL :$this->dataAsArray["year"];

	}
	protected function parseRated()
	{
		$this->movieDataObject->rated = empty($this->dataAsArray["rated"]) ? NULL :$this->dataAsArray["rated"];

	}
	protected function parseReleased()
	{
		$this->movieDataObject->released = empty($this->dataAsArray["released"]) ? NULL :$this->dataAsArray["released"];

	}
	protected function parseRuntime()
	{
		$this->movieDataObject->runtime = empty($this->dataAsArray["runtime"]) ? NULL :$this->dataAsArray["runtime"];

	}
	protected function parseGenre()
	{
		$this->movieDataObject->genre = empty($this->dataAsArray["genre"]) ? NULL :$this->dataAsArray["genre"];
	}
}