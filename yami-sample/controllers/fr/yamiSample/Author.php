<?php
namespace fr\yamiSample;

use yamiSample\Author as AuthorBase;

class Author extends AuthorBase {

	public function read() {
		parent::read();
		$this->view->special = array_merge($this->view->get('special', array()), array("This is applied by Controller extension:".__CLASS__));
	}

}