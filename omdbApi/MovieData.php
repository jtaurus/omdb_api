<?php namespace Jtaurus\OmdbApi;

use Exception;
use ArrayAccess;
/*
	This class holds movie/series/episode data.
*/

class MovieData implements ArrayAccess{

	// data container for ArrayAccess

	private $dataContainer = array();
	
	// data array sent by AbstractResultParser

	public $dataArray;

	public $title;
	public $year;
	public $rated;
	public $released;
	public $runtime;
	public $genre;

	public function __construct($dataArray){
		$this->dataArray = $dataArray;
		$this->parseMovieData();
	}

	public function offsetExists($offset){
		return isset($this->dataArray[$offset]);
	}

	public function offsetGet($offset){
		return isset($this->dataArray[$offset]) ? $this->dataArray[$offset] : null;
	}

	public function offsetSet($offset, $value){
		if(is_null($offset)){
			$this->dataArray[] = $value;
		}
		else{
			$this->dataArray[$offset] = $value;
		}

	}

	public function offsetUnset($offset){
		unset($this->dataArray[$offset]);
	}

	protected function parseMovieData()
	{
		$this->parseTitle();
		$this->parseYear();
		$this->parseRated();
		$this->parseReleased();
		$this->parseRuntime();
		$this->parseGenre();
	}

	public function getDataArray(){
		return $this->dataArray;
	}

	protected function parseTitle()
	{

		$this->title = empty($this->dataArray["title"]) ? NULL :$this->dataArray["title"];
	}
	protected function parseYear()
	{
		$this->year = empty($this->dataArray["year"]) ? NULL :$this->dataArray["year"];

	}
	protected function parseRated()
	{
		$this->rated = empty($this->dataArray["rated"]) ? NULL :$this->dataArray["rated"];

	}
	protected function parseReleased()
	{
		$this->released = empty($this->dataArray["released"]) ? NULL :$this->dataArray["released"];

	}
	protected function parseRuntime()
	{
		$this->runtime = empty($this->dataArray["runtime"]) ? NULL :$this->dataArray["runtime"];

	}
	protected function parseGenre()
	{
		$this->genre = empty($this->dataArray["genre"]) ? NULL :$this->dataArray["genre"];
	}

	public function getTitle(){
		return $this->title;
	}

	public function getYear(){
		return $this->year;
	}

	public function getRated(){
		return $this->rated;
	}

	public function getReleased(){
		return $this->released;
	}

	public function getRuntime(){
		return $this->runtime;
	}

	public function getGenre(){
		return $this->genre;
	}

}