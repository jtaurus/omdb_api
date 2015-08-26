<?php namespace Jtaurus\OmdbApi;

use Exception;

class SearchData
{
	// data returned by SearchParser
	protected $searchParserData;

	protected $searchResultsArray;

	public function __construct($searchParserData){
		$this->searchParserData = $searchParserData;
		$this->parseSearchParserDataIntoSearchResults();
	}

	protected function parseSearchParserDataIntoSearchResults(){
		foreach($this->searchParserData["search"] as $oneSearchResult){
			$this->searchResultsArray[] = new SearchResult($oneSearchResult);
		}
	}

	public function getSearchResultsArray(){
		return $this->searchResultsArray;
	}
}