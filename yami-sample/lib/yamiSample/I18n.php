<?php
namespace yamiSample;

class I18n {
	
	protected $language;
	protected $country;
	protected $state;
	protected $city;
	
	public function __construct($language, $country, $state, $city) {
		$this->language = $language;
		$this->country = $country;
		$this->state = $state;
		$this->city = $city;
	}

	public function get($key, $context = null) {
		if(is_array($key)) {
			if(count($key) == 2 && isset($context['count']) && is_int($context['count'])) {
				return ngettext($key[0], $key[1], $context['count']);
			}
			throw new I18n\Exception('Inconsistan call. When count is provided, both singular and plural from should be provided.');
		} elseif(is_string($key)) {
			return gettext($key);
		} else {
			throw new I18n\Exception('Inconsistan call. When count is provided, both singular and plural from should be provided.');
		}
	}
	
	
	private function convert($key, $context) {

	}
	
// 	public function get($key) {
// 		/// Some implementation of language content selector
// 		return '['.$this->language.']'.$key;
// 	}
	
}