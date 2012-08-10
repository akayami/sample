<?php
namespace filter\fr\yamiSample;

use yami\Router\Action\Controller;

class Author {
	
	public function read(Controller $controller) {
		$controller->view->special = array_merge($controller->view->get('special', array()), array("This is applied by filter:".__CLASS__));
		return $controller;
	}
	
}