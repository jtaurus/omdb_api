<?php namespace Jtaurus\OmdbApi;

use Jtaurus\OmdbApi\OmdbQuery;
use Jtaurus\OmdbApi\QueryBuilder;

class OmdbApi{
	
	protected $resultLength = "short";
	protected $dataType = "json";

	public function __construct(){
	}


	public function byID($id, $length = "short", $return = "json"){

	}

	public function byTitle($title, $length = "short", $return = "json"){

	}

	public function byTitleYear($title, $year, $length = "short", $return = "json"){

	}
}