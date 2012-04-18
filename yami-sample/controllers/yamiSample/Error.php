<?php
namespace yamiSample;

use yami\Http\Request;

use yamiSample\Router\Action\Controller as Controller;

class Error extends Controller {

	public function handle() {
		$this->view->code = Request::getInstance()->code;
		switch(Request::getInstance()->code) {
			case 404:
				$message = 'Not Found';
				break;
			case 500:
				$message = 'Server Error';
				break;
			default:
				$message = 'Server Error';
				$this->view->code = 500;
				break;
		}
		$this->view->message = $message;
	}
	
}