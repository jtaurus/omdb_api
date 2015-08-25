<?php namespace Jtaurus\OmdbApi;

use Jtaurus\OmdbApi\UnrecognizedApiParameterName\BadApiResponseException;
use Jtaurus\OmdbApi\OmdbResult;
use Jtaurus\OmdbApi\CreateFromApiResponse;

class OmdbQuery{
	
	public $guzzleInstance;

	public function __construct(){
		$this->guzzleInstance = new \GuzzleHttp\Client();
	}
	/**
	* @param queryUrl - Url to query
	* @return OmdbResult - OmdbResult object containing api data
	*/
	public function runQuery($queryUrl, CreateFromApiResponse $resultFactory){
		$response = $this->guzzleInstance->get($queryUrl);
		if($response->getStatusCode() != "200"){
			throw new BadApiResponseException("OMDB didn't respond properly.");
			}
		return $resultFactory->createFromApiResponse($response);
	}
}