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
	
	public function act() {
		$this->disableViewRendering();
		echo "hello";
		//print_r(Request::getInstance());
	}
	
}