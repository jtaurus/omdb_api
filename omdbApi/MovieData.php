<?php namespace Jtaurus\OmdbApi;

use Exception;
use ArrayAccess;
/*
	This class holds movie/series/episode data.
*/

class MovieData implements ArrayAccess{

	// data container for ArrayAccess

	private $dataContainer = array();
	

	public function __construct($dataArray){
		$this->dataContainer["dataArray"] = $dataArray;
		$this->parseMovieData();
	}

	public function offsetExists($offset){
		return isset($this->dataContainer["dataArray"][$offset]);
	}

	public function offsetGet($offset){
		return isset($this->dataContainer["dataArray"][$offset]) ? $this->dataContainer["dataArray"][$offset] : null;
	}

	public function offsetSet($offset, $value){
		if(is_null($offset)){
			$this->dataContainer[] = $value;
		}
		else{
			$this->dataContainer[$offset] = $value;
		}

	}

	public function offsetUnset($offset){
		unset($this->dataContainer[$offset]);
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
		return $this->dataContainer["dataArray"];
	}

	protected function parseTitle()
	{

		$this->dataContainer["title"] = empty($this->dataContainer["dataArray"]["title"]) ? NULL :$this->dataContainer["dataArray"]["title"];
	}
	protected function parseYear()
	{
		$this->dataContainer["year"] = empty($this->dataContainer["dataArray"]["year"]) ? NULL :$this->dataContainer["dataArray"]["year"];

	}
	protected function parseRated()
	{
		$this->dataContainer["rated"] = empty($this->dataContainer["dataArray"]["rated"]) ? NULL :$this->dataContainer["dataArray"]["rated"];

	}
	protected function parseReleased()
	{
		$this->dataContainer["released"] = empty($this->dataContainer["dataArray"]["released"]) ? NULL :$this->dataContainer["dataArray"]["released"];

	}
	protected function parseRuntime()
	{
		$this->dataContainer["runtime"] = empty($this->dataContainer["dataArray"]["runtime"]) ? NULL :$this->dataContainer["dataArray"]["runtime"];

	}
	protected function parseGenre()
	{
		$this->dataContainer["genre"] = empty($this->dataContainer["dataArray"]["genre"]) ? NULL :$this->dataContainer["dataArray"]["genre"];
	}

	public function getTitle(){
		return $this->dataContainer["title"];
	}

	public function getYear(){
		return $this->dataContainer["year"];
	}

	public function getRated(){
		return $this->dataContainer["rated"];
	}

	public function getReleased(){
		return $this->dataContainer["released"];
	}

	public function getRuntime(){
		return $this->dataContainer["runtime"];
	}

	public function getGenre(){
		return $this->dataContainer["genre"];
	}

}