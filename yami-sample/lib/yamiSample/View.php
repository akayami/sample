<?php
namespace yamiSample;

class View extends \yami\View {

	protected $languageURLPrefix;
	
	public function __construct(array $data = array()) {
		global $lang;
		parent::__construct($data);
		$this->languageURLPrefix = ($lang != 'en' ? '/'.$lang : '');
 	}
	
	public function uri($uri) {
		return $this->languageURLPrefix.$uri;
	}
	
	public function text($text) {
		global $lang;
		return '['.$lang.']'.$text;
	}
	
}