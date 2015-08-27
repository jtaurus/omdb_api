<?php

class ExampleTest extends TestCase {


	public function testOmdbApiServiceProviderInstantiates(){
		$this->assertInstanceOf("Jtaurus\OmdbApi\OmdbApi", $this->app->make("OmdbApi"));
	}


	public function testParameterSerializationInQueryBuilder(){
		$arrayOfParameters = array("i" => "tt2267998",
								"y" => "2014");
		$this->assertEquals("?i=tt2267998&y=2014&r=json", Jtaurus\OmdbApi\QueryBuilder::serialize_parameters($arrayOfParameters));
	}

	public function testQueryUrlCreationInQueryBuilder(){
		$arrayOfParameters = array("i" => "tt2267998",
								"y" => "2014");
		$this->assertEquals("http://www.omdbapi.com/?i=tt2267998&y=2014&r=json", Jtaurus\OmdbApi\QueryBuilder::create($arrayOfParameters));
	}

	public function testInvalidParametersGetCaught(){
		$this->assertEquals(false, Jtaurus\OmdbApi\QueryBuilder::checkIfParameterRecognized("some_unknown_parameter"));
	}

    /**
     * @expectedException Jtaurus\OmdbApi\UnrecognizedApiParameterName
     */
	public function testSerializeParametersThrowsExceptionWhenInvalidParameterNameUsed(){
			$parameters = array("invalid_parameter1" => "value", "invalid_parameter2" => "value2");
			$this->assertEquals("?invalid_parameter1=value&invalid_parameter2=value2", Jtaurus\OmdbApi\QueryBuilder::serialize_parameters($parameters));
	}

    /**
     * @expectedException Jtaurus\OmdbApi\InvalidParameterValue
     */
	public function testThrowsInvalidParameterValueWhenUsingInvalidParameterValue(){
		$parameters = array("t" => "some movie", "r" => "zip");
		Jtaurus\OmdbApi\QueryBuilder::create($parameters);
	}

    /**
     * @expectedException Jtaurus\OmdbApi\UnrecognizedDataStructureReturnedByApi
     */
	public function testOmdbResultThrowsExceptionWhenReceivingUnknownDataFormat(){
		$omdbResultInstance = new Jtaurus\OmdbApi\OmdbResult("some_unknown_data_format");
	}

	public function testIfOmdbQueryCreatesOmdbResultObject(){
		$queryInstance = new Jtaurus\OmdbApi\OmdbQuery();
		$omdbResultInstance = $queryInstance->runQuery("http://www.omdbapi.com/?t=gun&y=&plot=short&r=json", new Jtaurus\OmdbApi\OmdbResultFactory());
		$this->assertInstanceOf("Jtaurus\OmdbApi\OmdbResult", $omdbResultInstance);
	}

	public function testIfOmdbResultReceivesProperJsonFormattedData(){
		$queryInstance = new Jtaurus\OmdbApi\OmdbQuery();
		$omdbResultInstance = $queryInstance->runQuery("http://www.omdbapi.com/?t=gun&y=&plot=short&r=json", new Jtaurus\OmdbApi\OmdbResultFactory());
		$received = $omdbResultInstance->getJson();
		$this->assertEquals($omdbResultInstance->isJson($received), true);
	}

	public function testFailsOnPassingDisallowedParameterValue(){
		$this->assertEquals(false, Jtaurus\OmdbApi\QueryBuilder::checkIfParameterContainsAllowedValue("type", "music"));
	}

	public function testPassesOnPassingAllowedParameterValue(){
		$this->assertEquals(true, Jtaurus\OmdbApi\QueryBuilder::checkIfParameterContainsAllowedValue("type", "movie"));		
	}

	public function testPassesOnPassingUnfilteredParameter(){
		$this->assertEquals(true, Jtaurus\OmdbApi\QueryBuilder::checkIfParameterContainsAllowedValue("y", "2015"));	
	}

	public function testThatXmlAndJsonConversionResultsInTheSameData(){
		$omdbApiInstance = App::make('OmdbApi');
		$resultOfXmlConversion = $omdbApiInstance->byTitle("leon the professional", "full", "xml");
		$resultOfJsonConversion = $omdbApiInstance->byTitle("leon the professional", "full", "json");
		$this->assertEquals($resultOfJsonConversion, $resultOfXmlConversion);
	}

	public function testThatXmlAndJsonConversionResultsInExactlyTheSameData(){
		$omdbApiInstance = App::make('OmdbApi');
		$resultOfXmlConversion = $omdbApiInstance->byTitle("gun", "full", "xml");
		$resultOfJsonConversion = $omdbApiInstance->byTitle("gun", "full", "json");
		$this->assertEquals($resultOfXmlConversion["title"], $resultOfJsonConversion["title"]);	
	}

	public function testMovieDataCanBeAccessedViaArrayAccess(){
		$omdbApiInstance = App::make('OmdbApi');
		$movieData = $omdbApiInstance->byTitle("guns");
		$this->assertEquals($movieData["title"], $movieData->getTitle());
	}

	// Search related tests:

	public function testSearchParserReturnsArrayOfData(){
		$parserInstance = (new Jtaurus\OmdbApi\OmdbQuery)->runQuery("http://www.omdbapi.com/?s=gun&r=json", new Jtaurus\OmdbApi\SearchParserFactory);
		$this->assertInternalType("array", $parserInstance->getDataArray());
	}

	public function testSearchParserReturnsSearchDataObject(){
		$parserInstance = (new Jtaurus\OmdbApi\OmdbQuery)->runQuery("http://www.omdbapi.com/?s=gun&r=json", new Jtaurus\OmdbApi\SearchParserFactory);
		$this->assertInstanceOf("Jtaurus\OmdbApi\SearchData", $parserInstance->getSearchData());
	}
	
	public function testSearchDataContainsAnArrayOfSearchResults(){
		$parserInstance = (new Jtaurus\OmdbApi\OmdbQuery)->runQuery("http://www.omdbapi.com/?s=gun&r=json", new Jtaurus\OmdbApi\SearchParserFactory);
		$this->assertInternalType("array", $parserInstance->getSearchData()->getSearchResultsArray());
		$this->assertInstanceOf("Jtaurus\OmdbApi\SearchResult", $parserInstance->getSearchData()->getSearchResultsArray()[0]);
	}

	public function testSearchResultReturnsData(){
		$parserInstance = (new Jtaurus\OmdbApi\OmdbQuery)->runQuery("http://www.omdbapi.com/?s=gun&r=json", new Jtaurus\OmdbApi\SearchParserFactory);
		$searchResultReference = $parserInstance->getSearchData()->getSearchResultsArray()[0];
		$this->assertNotNull($searchResultReference->getTitle());
		$this->assertNotNull($searchResultReference->getYear());
		$this->assertNotNull($searchResultReference->getImdbId());
		$this->assertNotNull($searchResultReference->getResultType());
	}

	public function testSearchResultConvertsToMovieData(){
		$parserInstance = (new Jtaurus\OmdbApi\OmdbQuery)->runQuery("http://www.omdbapi.com/?s=gun&r=json", new Jtaurus\OmdbApi\SearchParserFactory);
		$searchResultReference = $parserInstance->getSearchData()->getSearchResultsArray()[0];
		$this->assertInstanceOf("Jtaurus\OmdbApi\MovieData", $searchResultReference->getMovieData());
	}

	public function testSearchResultImplementsArrayAccess()
	{
		$omdApiInstance = new Jtaurus\OmdbApi\OmdbApi();
		$someSearchResult = $omdApiInstance->getFirstFromSearch("gun");
		$this->assertNotNull($someSearchResult["title"]);
		$this->assertNotNull($someSearchResult["year"]);
		$this->assertNotNull($someSearchResult["imdbId"]);
		$this->assertNotNull($someSearchResult["resultType"]);
	}

	public function testSearchResultConvertToMovieDataReturnsUsefulData()
	{
		$parserInstance = (new Jtaurus\OmdbApi\OmdbQuery)->runQuery("http://www.omdbapi.com/?s=gun&r=json", new Jtaurus\OmdbApi\SearchParserFactory);
		$searchResultReference = $parserInstance->getSearchData()->getSearchResultsArray()[0];
		$this->assertNotNull($searchResultReference->getMovieData()->getTitle());
	}

	public function testIfOmdbFacadeWorks()
	{
		$this->assertInstanceOf("Jtaurus\OmdbApi\MovieData", Jtaurus\OmdbApi\Omdb::byTitle("gun"));
		$this->assertInstanceOf("Jtaurus\OmdbApi\SearchData", Jtaurus\OmdbApi\Omdb::search("gun"));
	}

	public function testQueryBuilderAddsRequestInformationEvenIfWeDontProvideIt()
	{
		$createdUrl = Jtaurus\OmdbApi\QueryBuilder::create(array("s" => "gun"));
		$this->assertNotEquals(false, strstr($createdUrl, "r="));
	}

	public function testQueryBuilderDeaultsToJsonRequestTypeWhenWeDontProvideAnything()
	{
		$createdUrl = Jtaurus\OmdbApi\QueryBuilder::create(array("s" => "gun"));
		$this->assertNotEquals(false, strstr($createdUrl, "&r=json"));
	}

    /**
     * @expectedException Jtaurus\OmdbApi\ZeroResultsReturned
     */
	public function testOmdbResultThrowsZeroResults()
	{
		$parserInstance = (new Jtaurus\OmdbApi\OmdbQuery)->runQuery("http://www.omdbapi.com/?t=zxcvzxcvzxcvzx&r=json", new Jtaurus\OmdbApi\OmdbResultFactory);
	}
    /**
     * @expectedException Jtaurus\OmdbApi\ZeroResultsReturned
     */
	public function testSearchParserThrowsZeroResults()
	{
		$parserInstance = (new Jtaurus\OmdbApi\OmdbQuery)->runQuery("http://www.omdbapi.com/?s=zxcvzxcvzxcvzx&r=json", new Jtaurus\OmdbApi\SearchParserFactory);
	}
}
