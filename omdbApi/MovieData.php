<?php namespace Jtaurus\OmdbApi;

use Exception;

/*
	This class holds movie/series/episode data.
*/

class MovieData{
	
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