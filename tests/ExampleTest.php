<?php

class ExampleTest extends TestCase {


	public function testOmdbApiServiceProviderInstantiates(){
		$this->assertInstanceOf("Jtaurus\OmdbApi\OmdbApi", $this->app->make("OmdbApi"));
	}


	public function testParameterSerializationInQueryBuilder(){
		$arrayOfParameters = array("i" => "tt2267998",
								"y" => "2014");
		$this->assertEquals("?i=tt2267998&y=2014", Jtaurus\OmdbApi\QueryBuilder::serialize_parameters($arrayOfParameters));
	}

	public function testQueryUrlCreationInQueryBuilder(){
		$arrayOfParameters = array("i" => "tt2267998",
								"y" => "2014");
		$this->assertEquals("http://www.omdbapi.com/?i=tt2267998&y=2014", Jtaurus\OmdbApi\QueryBuilder::create($arrayOfParameters));
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
		$omdbResultInstance = $queryInstance->runQuery("http://www.omdbapi.com/?s=gun&y=&plot=short&r=json");
		$this->assertInstanceOf("Jtaurus\OmdbApi\OmdbResult", $omdbResultInstance);
	}

	public function testIfOmdbResultReceivesProperJsonFormattedData(){
		$queryInstance = new Jtaurus\OmdbApi\OmdbQuery();
		$omdbResultInstance = $queryInstance->runQuery("http://www.omdbapi.com/?s=gun&y=&plot=short&r=json");
		$this->assertEquals($omdbResultInstance->isJson(), true);
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
}
