<?php namespace Jtaurus\OmdbApi;

use Exception;

class SearchResult
{
	// Blob passed by SearchData
	protected $dataBlob;

	protected $title;
	protected $year;
	protected $imdbId;
	protected $resultType;

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
}