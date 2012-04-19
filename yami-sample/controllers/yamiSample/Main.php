<?php
namespace yamiSample;

use yami\Http\Request;

use yami\Router\Action\Controller as Controller;

class Main extends Controller {

	public function defaultAction() {

	}
	
	public function specialAction() {
		$this->view->bbb = Request::getInstance()->bbb;
	}
	
}