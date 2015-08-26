<?php namespace Jtaurus\OmdbApi;

use Exception;
use Jtaurus\OmdbApi\QueryBuilder;
use Jtaurus\OmdbApi\OmdbResultFactory;
use ArrayAccess;

class SearchResult implements ArrayAccess{

	protected $dataContainer = array();
	// Blob passed by SearchData
	protected $dataBlob;
	protected $title;
	protected $year;
	protected $imdbId;
	protected $resultType;

	// movie data reference, if fetched:
	protected $movieDataReference;

	public function __construct($dataBlob)
	{
		$this->dataBlob = $dataBlob;
		$this->parseDataBlobIntoInternalPropeteries();
	}

	public function offsetExists ( $offset )
	{
		return isset($this->dataContainer[$offset]);
	}

	public function offsetGet($offset)
	{
		if(!isset($this->dataContainer[$offset]))
		{
			return null;
		}
		else
		{
			return $this->dataContainer[$offset];
		}
	}
	
	public function offsetSet($offset, $value)
	{
		if(is_null($offset))
		{
			$this->dataContainer[] = $value;
		}
		else{
			$this->dataContainer[$offset] = $value;
		}

	}

	public function offsetUnset($offset)
	{
		unset($this->dataContainer[$offset]);
	}

	protected function parseDataBlobIntoInternalPropeteries()
	{
		$this->parseTitle();
		$this->parseYear();
		$this->parseImdbId();
		$this->parseResultType();
	}

	protected function parseTitle()
	{
		$this->title = $this->dataBlob["title"];
	}

	protected function parseYear()
	{
		$this->year = $this->dataBlob["year"];
	}

	protected function parseImdbId()
	{
		$this->imdbId = $this->dataBlob["imdbid"];
	}

	protected function parseResultType()
	{
		$this->resultType = $this->dataBlob["type"];
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getYear()
	{
		return $this->year;
	}

	public function getImdbId()
	{
		return $this->imdbId;
	}

	public function getResultType()
	{
		return $this->resultType;
	}

	public function getMovieData()
	{
		if(isset($this->movieDataReference))
		{
			return $this->movieDataReference;
		}
		else
		{
			$this->fetchMovieData();
			return $this->movieDataReference;
		}
	}

	protected function fetchMovieData()
	{
		$queryUrl = (new QueryBuilder)->create(array("i" => $this->imdbId));
		$omdbResultParserInstance = (new OmdbQuery)->runQuery($queryUrl, new OmdbResultFactory);
		$this->movieDataReference = $omdbResultParserInstance->getMovieData();
	}
}