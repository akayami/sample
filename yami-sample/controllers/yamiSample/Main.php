<?php
namespace yamiSample;

use yamiSample\Controller\Standard;
use yami\Http\Request;



class Main extends Standard {
	
	public function defaultAction() {
		
	}
	
	public function specialAction() {
		$this->view->bbb = Request::getInstance()->bbb;
	}
	
	public function act() {
		$this->disableViewRendering();
		//echo "hello";
		//print_r(Request::getInstance());
	}
	
}