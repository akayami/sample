<?php
namespace yamiSample;

class View extends \yami\View {

	protected $languageURLPrefix;
	
	public function __construct(array $data = array()) {
		global $content;
		parent::__construct($data);
		$this->languageURLPrefix = ($content['lang'] != 'en' ? '/'.$content['lang'] : '');
 	}
	
	public function uri($uri) {
		return $this->languageURLPrefix.$uri;
	}
	
	public function ngettext($sform, $pform, $context) {
		return $this->text(array($sform, $pform), $context);
	}
	
	public function _($text, $pform = null, $context = null) {
		if($pform != null) {
			return $this->text(array($text, $pform), $context);
		} else {
			return $this->text($text);
		}
	}
	
	public function text($text, $context = null) {
		global $i18n;
		return sprintf($i18n->get($text, $context), $context['count']);
	}	
	
}