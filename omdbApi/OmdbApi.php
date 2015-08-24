<?php namespace Jtaurus\OmdbApi;

use Jtaurus\OmdbApi\OmdbQuery;
use Jtaurus\OmdbApi\QueryBuilder;

class OmdbApi{
	
	public function __construct(){
	}


	public function byID($i, $length = "short", $return = "json"){
		$queryUrl = QueryBuilder::create(array("i" => $i, "plot" => $length, "r" => $return));
		$omdbResult = (new OmdbQuery)->runQuery($queryUrl);
		return $omdbResult->getAssocArray();
	}

	public function byTitle($title, $length = "short", $return = "json"){
		$queryUrl = QueryBuilder::create(array("t" => $title, "plot" => $length, "r" => $return));
		$omdbResult = (new OmdbQuery)->runQuery($queryUrl);
		return $omdbResult->getAssocArray();
	}

	public function byTitleYear($title, $year, $length = "short", $return = "json"){
		$queryUrl = QueryBuilder::create(array("t" => $title, "y" => $year, "plot" => $length, "r" => $return));
		$omdbResult = (new OmdbQuery)->runQuery($queryUrl);
		return $omdbResult->getAssocArray();
	}
}