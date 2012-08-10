<?php
namespace yamiSample\Controller;
use yamiSample\View;

use yami\Router\Action\Controller;

class Standard extends Controller {
	
	public function __construct($action = null) {
		parent::__construct($action);
		$this->view = new View();
		$this->setActionName($action);	
	}	
}