<?php namespace Jtaurus\OmdbApi;

use Jtaurus\OmdbApi\CreateFromApiResponse;
use Jtaurus\OmdbApi\SearchParser;

class SearchResultFactory implements CreateFromApiResponse{
	public function createFromApiResponse($apiResponse){
		return new SearchParser((string) $apiResponse->getBody());
	}
}