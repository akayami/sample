<?php
namespace yamiSample;
use yamiSample\Entity\Authors;
use yami\Router\Action\Controller;

class Book extends Controller {

	public function defaultAction() {
		$this->view->data = Authors::getAll();		
	}
	
} 