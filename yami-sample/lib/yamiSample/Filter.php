<?php
namespace yamiSample;

class Filter {

	protected $namespace;
	public function __construct($value) {
		$this->namespace = $value;
	}
	
	public function __toString() {
		return $this->namespace.'\\';
	}
	
}