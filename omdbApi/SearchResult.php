<?php namespace Jtaurus\OmdbApi;

use Exception;
use Jtaurus\OmdbApi\QueryBuilder;
use Jtaurus\OmdbApi\OmdbResultFactory;

class SearchResult
{
	// Blob passed by SearchData
	protected $dataBlob;

	protected $title;
	protected $year;
	protected $imdbId;
	protected $resultType;

	// movie data reference, if fetched:
	protected $movieDataReference;

	public function __construct($dataBlob){
		$this->dataBlob = $dataBlob;
		$this->parseDataBlobIntoInternalPropeteries();
	}

	protected function parseDataBlobIntoInternalPropeteries(){
		$this->parseTitle();
		$this->parseYear();
		$this->parseImdbId();
		$this->parseResultType();
	}

	protected function parseTitle(){
		$this->title = $this->dataBlob["title"];
	}

	protected function parseYear(){
		$this->year = $this->dataBlob["year"];
	}

	protected function parseImdbId(){
		$this->imdbId = $this->dataBlob["imdbid"];
	}

	protected function parseResultType(){
		$this->resultType = $this->dataBlob["type"];
	}

	public function getTitle(){
		return $this->title;
	}

	public function getYear(){
		return $this->year;
	}

	public function getImdbId(){
		return $this->imdbId;
	}

	public function getResultType(){
		return $this->resultType;
	}

	public function getMovieData(){
		if(isset($this->movieDataReference)){
			return $this->movieDataReference;
		}
		else{
			$this->fetchMovieData();
			return $this->movieDataReference;
		}
	}

	protected function fetchMovieData(){
		$queryUrl = (new QueryBuilder)->create(array("i" => $this->imdbId));
		$omdbResultParserInstance = (new OmdbQuery)->runQuery($queryUrl, new OmdbResultFactory);
		$this->movieDataReference = $omdbResultParserInstance->getMovieData();
	}
}