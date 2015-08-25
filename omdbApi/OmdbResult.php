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
	public $movieDataObject;


	public function __construct($apiResponseBlob){
		$this->handleApiResponse($apiResponseBlob);
		$this->instantiateMovieDataObject();
	}
	protected function instantiateMovieDataObject(){
		$this->movieDataObject = new MovieData($this->dataAsArray);
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



}