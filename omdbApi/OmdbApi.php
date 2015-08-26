<?php namespace Jtaurus\OmdbApi;

use Jtaurus\OmdbApi\OmdbQuery;
use Jtaurus\OmdbApi\QueryBuilder;
use Jtaurus\OmdbApi\OmdbResultFactory;
use Jtaurus\OmdbApi\SearchResultFactory;

class OmdbApi{
	
	public function __construct(){
	}


	public function byID($i, $length = "short", $return = "json"){
		$queryUrl = QueryBuilder::create(array("i" => $i, "plot" => $length, "r" => $return));
		$omdbResult = (new OmdbQuery)->runQuery($queryUrl, new OmdbResultFactory());
		return $omdbResult->getMovieData();
	}

	public function byTitle($title, $length = "short", $return = "json"){
		$queryUrl = QueryBuilder::create(array("t" => $title, "plot" => $length, "r" => $return));
		$omdbResult = (new OmdbQuery)->runQuery($queryUrl, new OmdbResultFactory());
		return $omdbResult->getMovieData();
	}

	public function byTitleYear($title, $year, $length = "short", $return = "json"){
		$queryUrl = QueryBuilder::create(array("t" => $title, "y" => $year, "plot" => $length, "r" => $return));
		$omdbResult = (new OmdbQuery)->runQuery($queryUrl, new OmdbResultFactory());
		return $omdbResult->getMovieData();
	}

	public function search($query, $return = "json"){
		$queryUrl = QueryBuilder::create(array("s" => $query, "r" => $return));
		echo $queryUrl;
		$searchResult = (new OmdbQuery)->runQuery($queryUrl, new SearchParserFactory());
		return $searchResult;
	}
}