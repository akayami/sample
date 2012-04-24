<?php
namespace yamiSample;

use yami\Router\Action\Controller;

class AuthorController extends Controller {

	public function defaultAction() {
		$this->disableViewRendering();
		print_r(Entity\Authors::getAll());		
	}
	
} 