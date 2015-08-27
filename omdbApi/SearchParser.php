<?php namespace Jtaurus\OmdbApi;

use Exception;
use Jtaurus\OmdbApi\AbstractResultParser;
use Jtaurus\OmdbApi\SearchData;

class SearchParser extends AbstractResultParser{
	
	protected $searchDataReference;

	public function __construct($apiResponseBlob)
	{
		$this->handleApiResponse($apiResponseBlob);
		$this->checkIfRequestSuccessful();
		$this->parseResponseIntoAnArrayOfMovies();
		$this->createSearchDataObject();
	}

	// @overrides AbstractResultParser->parseResponseMetaData
	protected function parseResponseMetaData()
	{
		$this->responseSuccessful = (isset($this->dataAsArray["search"])) ? true : false;
		$this->errorMessage =  (isset($this->dataAsArray["error"])) ? $this->dataAsArray["error"] : null;
	}

	protected function checkIfRequestSuccessful()
	{
		if(!$this->getResponseStatus())
		{
			throw new ZeroResultsReturned($this->getErrorMessage());
		}
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