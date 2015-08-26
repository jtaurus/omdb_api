<?php namespace Jtaurus\OmdbApi;

use Exception;
use Jtaurus\OmdbApi\AbstractResultParser;
use Jtaurus\OmdbApi\SearchData;

class SearchParser extends AbstractResultParser{
	
	protected $searchDataReference;

	public function __construct($apiResponseBlob)
	{
		$this->handleApiResponse($apiResponseBlob);
		$this->parseResponseIntoAnArrayOfMovies();
		$this->createSearchDataObject();
	}

	public function createSearchDataObject()
	{
		$this->searchDataReference = new SearchData($this->dataAsArray);
	}

	protected function parseResponseIntoAnArrayOfMovies()
	{
		$this->foundResults = $this->dataAsArray["search"];
	}

	public function getArrayOfFoundResults()
	{
		return $this->foundResults;
	}

	public function getDataArray()
	{
		return $this->dataAsArray;
	}

	public function getSearchData()
	{
		return $this->searchDataReference;
	}
}