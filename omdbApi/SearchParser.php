<?php namespace Jtaurus\OmdbApi;

use Exception;
use Jtaurus\OmdbApi\AbstractResultParser;

class SearchParser extends AbstractResultParser

{
	protected $foundResults;

	public function __construct($apiResponseBlob){
		$this->handleApiResponse($apiResponseBlob);
		$this->parseResponseIntoAnArrayOfMovies();
	}

	protected function parseResponseIntoAnArrayOfMovies(){
		$this->foundResults = $this->dataAsArray["search"];
	}

	public function getArrayOfFoundResults(){
		return $this->foundResults;
	}
}