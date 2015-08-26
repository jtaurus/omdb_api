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
		$this->dataContainer["dataBlob"] = $dataBlob;
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
		$this->dataContainer["title"] = $this->dataContainer["dataBlob"]["title"];
	}

	protected function parseYear()
	{
		$this->dataContainer["year"] = $this->dataContainer["dataBlob"]["year"];
	}

	protected function parseImdbId()
	{
		$this->dataContainer["imdbId"] = $this->dataContainer["dataBlob"]["imdbid"];
	}

	protected function parseResultType()
	{
		$this->dataContainer["resultType"] = $this->dataContainer["dataBlob"]["type"];
	}

	public function getTitle()
	{
		return $this->dataContainer["title"];
	}

	public function getYear()
	{
		return $this->dataContainer["year"];
	}

	public function getImdbId()
	{
		return $this->dataContainer["imdbId"];
	}

	public function getResultType()
	{
		return $this->dataContainer["resultType"];
	}

	public function getMovieData()
	{
		if(isset($this->dataContainer["movieDataReference"]))
		{
			return $this->dataContainer["movieDataReference"];
		}
		else
		{
			$this->fetchMovieData();
			return $this->dataContainer["movieDataReference"];
		}
	}

	protected function fetchMovieData()
	{
		$queryUrl = (new QueryBuilder)->create(array("i" => $this->imdbId));
		$omdbResultParserInstance = (new OmdbQuery)->runQuery($queryUrl, new OmdbResultFactory);
		$this->dataContainer["movieDataReference"] = $omdbResultParserInstance->getMovieData();
	}
}