<?php namespace Jtaurus\OmdbApi;

use Jtaurus\OmdbApi\CreateFromApiResponse;
use Jtaurus\OmdbApi\OmdbResult;

class OmdbResultFactory implements CreateFromApiResponse{
	/*
		@param - guzzlehttp response
		@return - OmdbResult object
	*/
	public function createFromApiResponse($apiResponse)
	{
		return new OmdbResult((string) $apiResponse->getBody());
	}
}