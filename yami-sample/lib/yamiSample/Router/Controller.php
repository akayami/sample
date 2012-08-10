<?php
namespace yamiSample\Router;

use yamiSample\ContextLevel;

use yami\Router\Route;

use yami\Router\Controller as yamiCtrl;

use yami\Router\Action\Controller as ActionController;

class Controller extends yamiCtrl {

	protected $context;
	
	public function setContext(ContextLevel $c) {
		$this->context = $c;		
	}

	/**
	 * (non-PHPdoc)
	 * @see yami\Router.Controller::handleRoute()
	 */
	protected function handleRoute(Route $route) {
		$possibles = array($this->context.$route->getController(), $route->getController());
		set_error_handler(function($errno, $errstr, $errfile, $errline) {
			throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
		});
		$found = false;
		foreach($possibles as $cont) {
			try {
				$a = new $cont($route->getAction());
				$found = true;
				break;
			} catch(\ErrorException $e) {
				// Controller for some specific url missing.
			}
		}
		restore_error_handler();
		if(!$found) {
			throw new \Exception('Failed to find a controller matching current context');
		}
		try {
			if($a->{$route->getAction()}() !== false) {
				$a = $this->applyFilters($a, $route);
				$a->render();
				return true;
			}
		} catch(\Exception $e) {
			throw $e;
		}	
	}
	
	/**
	 * 
	 * @param ActionController $c
	 * @return ActionController
	 */
	protected function applyFilters(ActionController $c, Route $route) {
		global $filters;
		set_error_handler(function($errno, $errstr, $errfile, $errline) {
			throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
		});
		foreach($filters as $filter) {
			$execute = false;
			$name = 'filter\\'.$filter.$route->getController();
			try {				
				$f = new $name;
				$execute = true;
			} catch(\ErrorException $e) {
				
			}			
			if($execute && method_exists($f, $route->getAction())) {
				$c = $f->{$route->getAction()}($c);
			}
		}
		restore_error_handler();
		return $c;
	}

	/**
	 * @return Controller
	 */
	static public function getInstance() {
		return parent::getInstance();
	}	
}