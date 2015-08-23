<?php

class ExampleTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		$response = $this->call('GET', '/');

		$this->assertEquals(200, $response->getStatusCode());
	}

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

	public function testIfOmdbQueryCreatesOmdbResultObject(){
		$queryInstance = new Jtaurus\OmdbApi\OmdbQuery();
		$omdbResultInstance = $queryInstance->runQuery("http://www.omdbapi.com/?s=gun&y=&plot=short&r=json");
		$this->assertInstanceOf("Jtaurus\OmdbApi\OmdbResult", $omdbResultInstance);
	}


}
