<?php
namespace yamiSample\ContextLevel;

use yamiSample\ContextLevel;

class Language extends ContextLevel {
	
	protected $language;
	
	public function __construct($languageCode = 'en') {
		$this->language = $languageCode;
	}
	
	/**
	 * 
	 * @param string $languageCode
	 * @return Language
	 */
	public static function make($languageCode = 'en') {
		return new static($languageCode);
	}
	
	protected function prefix() {
		switch($this->language) {
			case 'en':
				return array();
			default:
				return array($this->language.'\\');
		}
	}
	
	public function __toString() {
		return $this->prefix();
	}
}