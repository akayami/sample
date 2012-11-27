<?php
namespace filter\white\yamiSample;

use Bacon\Router\Action\Controller;

class Author {
	
	/**
	 * 
	 * @param Controller $controller
	 * @return Controller
	 */
	public function read(Controller $controller) {
		$controller->view->special = array_merge($controller->view->get('special', array()), array("This is applied by filter:".__CLASS__));
		return $controller;
	}
	
}