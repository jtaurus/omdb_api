<?php namespace Jtaurus\OmdbApi;

use Exception;

class SearchResult
{
	// Blob passed by SearchData
	protected $dataBlob;

	public function __construct($dataBlob){
		$this->dataBlob = $dataBlob;
	}
}