<?php
namespace yamiSample;

abstract class ContextLevel {
	
	/**
	 * 
	 * @var Context
	 */
	protected $child;

	
	public function append(ContextLevel $c) {
		$this->child = $c;
	}
}