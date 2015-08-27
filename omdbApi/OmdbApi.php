<?php namespace Jtaurus\OmdbApi;

use Jtaurus\OmdbApi\OmdbQuery;
use Jtaurus\OmdbApi\QueryBuilder;
use Jtaurus\OmdbApi\OmdbResultFactory;
use Jtaurus\OmdbApi\SearchResultFactory;

class OmdbApi{
	
	protected $omdbQueryInstance;

	public function __construct()
	{
		$this->omdbQueryInstance = new OmdbQuery;
	}


	public function byID($i, $length = "short")
	{
		$queryUrl = QueryBuilder::create(array("i" => $i, "plot" => $length));
		$omdbResult = $this->omdbQueryInstance->runQuery($queryUrl, new OmdbResultFactory());
		return $omdbResult->getMovieData();
	}

	public function byTitle($title, $length = "short")
	{
		$queryUrl = QueryBuilder::create(array("t" => $title, "plot" => $length));
		$omdbResult = $this->omdbQueryInstance->runQuery($queryUrl, new OmdbResultFactory());
		return $omdbResult->getMovieData();
	}

	public function byTitleYear($title, $year, $length = "short")
	{
		$queryUrl = QueryBuilder::create(array("t" => $title, "y" => $year, "plot" => $length));
		$omdbResult = $this->omdbQueryInstance->runQuery($queryUrl, new OmdbResultFactory());
		return $omdbResult->getMovieData();
	}

	public function search($query)
	{
		$queryUrl = QueryBuilder::create(array("s" => $query));
		$searchParserInstance = $this->omdbQueryInstance->runQuery($queryUrl, new SearchParserFactory());
		return $searchParserInstance->getSearchData();
	}

	public function getFirstFromSearch($query)
	{
		$queryUrl = QueryBuilder::create(array("s" => $query));
		$searchParserInstance = $this->omdbQueryInstance->runQuery($queryUrl, new SearchParserFactory);
		return $searchParserInstance->getSearchData()->getSearchResultsArray()[0];
	}
}