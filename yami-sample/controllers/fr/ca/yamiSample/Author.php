<?php
namespace fr\ca\yamiSample;

use fr\yamiSample\Author as ParentAuthor;

class Author extends ParentAuthor {
	
	public function read() {
		parent::read();
		$this->view->special = array_merge($this->view->get('special', array()), array("This is applied by Controller extension:".__CLASS__));
	}
	
}