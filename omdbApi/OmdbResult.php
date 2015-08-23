<?php namespace Jtaurus\OmdbApi;


class OmdbResult{

	protected $apiResponseBlob;
	protected $jsonData;
	protected $xmlData;


	public function __construct($apiResponseBlob){
		$this->jsonData = $apiResponseBlob;
	}

	public function isJson(){
		if( json_decode($this->apiResponseBlob) == NULL){
			return false;
		}
		else{
			return true;
		}
	}

	public function getJson(){
		return $this->jsonData;
	}

}