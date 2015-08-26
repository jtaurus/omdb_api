<?php namespace Jtaurus\OmdbApi;

use Exception;

class SearchData
{
	// data returned by SearchParser
	protected $searchParserData;

	protected $searchResultsArray;

	public __construct($searchParserData){
		$this->searchParserData = $searchParserData;
	}
}