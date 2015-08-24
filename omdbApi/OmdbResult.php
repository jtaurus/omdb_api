<?php namespace Jtaurus\OmdbApi;


class OmdbResult{

	protected $apiResponseBlob;
	protected $jsonData;
	protected $xmlData;
	protected $dataAsArray;

	protected $title;
	protected $year;
	protected $rated;
	protected $released;
	protected $runtime;
	protected $genre;

	public function __construct($apiResponseBlob){
		$this->jsonData = $apiResponseBlob;
		$this->convertJsonToArray();
		$this->parseBasicData();
	}

	public function convertJsonToArray(){
		$this->dataAsArray = json_decode($this->jsonData, true);
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

	public function parseBasicData(){

	}

}