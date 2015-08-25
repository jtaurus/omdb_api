<?php namespace Jtaurus\OmdbApi;

use Jtaurus\OmdbApi\CreateFromApiResponse;
use Jtaurus\OmdbApi\SearchResult;

class SearchResultFactory implements CreateFromApiResponse{
	public function createFromApiResponse($apiResponse){
		return new SearchResult((string) $apiResponse->getBody());
	}
}