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
	
	
	public function __toString() {
		switch($this->language) {
			case 'en':
				return '';
			default:
				return $this->language.'\\';
		}
	}
}