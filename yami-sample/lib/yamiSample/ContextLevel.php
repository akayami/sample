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
	
	public function get() {
		if(isset($this->child)) {
			$a = $this->child->get();
			$out = array();
			foreach($a as $item) {
				foreach($this->prefix() as $p) {
					$out[] = $p.$item;
				}
			}
			return array_merge($this->prefix(), $out);
		} else {
			return $this->prefix();
		}
	}
	
	abstract protected function prefix();
}