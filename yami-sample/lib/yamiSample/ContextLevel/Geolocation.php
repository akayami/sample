<?php
namespace yamiSample\ContextLevel;

use yamiSample\ContextLevel;

class Geolocation extends ContextLevel {

	protected $country;
	protected $state;
	protected $city;

	/**
	 * 
	 * @param string $country
	 * @param string $state
	 * @param string $city
	 */
	public function __construct($country = null, $state = null, $city = null) {
		$this->country = $country;
		$this->state = $state;
		$this->city = $city;
	}
	
	protected function prefix() {
		$a = array();
		$path = '';
		if(!is_null($this->country)) {
			$path .= $this->country.'\\';
			$a[] = $path;
		}
		if (!is_null($this->state)) {
			$path .= $this->state.'\\'; 
			$a[] = $path;
		}
		if(!is_null($this->city)) {
			$path .= $this->city.'\\';
			$a[] = $path;
		}
		return $a;
	}

	/**
	 *
	 * @param string $languageCode
	 * @return Language
	 */
	public static function make($country, $state = null, $city = null) {
		return new static($country, $state, $city);
	}
}