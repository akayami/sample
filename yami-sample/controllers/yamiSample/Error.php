<?php
namespace yamiSample;

use yami\Http\Request;
use yami\Router\Action\Controller as Controller;

class Error extends Controller {

	public function handle() {
		$this->view->code = Request::getInstance()->code;
		$body = '';
		switch(Request::getInstance()->code) {
			case 404:
				$message = 'Not Found';
				break;
			case 500:
				$body = Request::getInstance()->error->getPrevious()->getMessage();
				$message = 'Server Error';
				break;
			default:
				$message = 'Server Error';
				$this->view->code = 500;
				$body = Request::getInstance()->error->getPrevious()->getMessage();
				break;
		}
		$this->view->body = $body;
		$this->view->message = $message;
	}
	
}