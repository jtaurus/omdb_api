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

	public function getMovieData(){
		return $this->movieDataObject;
	}
}