<?php
namespace yamiSample\Router\Action;

use yami\View;

use yami\Router\Controller as AppController;

class Controller extends \yami\Router\Action\Controller {
	
	public $view;
	protected $render = true;

	/**
	 * Extends the construction of basic controller. Implements the way view is handled.
	 * 
	 * @param string $action
	 */
	public function __construct($action) {
		$app = AppController::getInstance();
		parent::__construct($action);
		$this->view = new View();
		$this->view->setActionName(str_replace('\\', DIRECTORY_SEPARATOR, $app->route->getController().'\\'.$app->route->getAction()));
	}
	
	public function disableViewRendering() {
		$this->render = false;
	}
	
	public function enableViewRendering() {
		$this->render = true;
	}
	
	public function __destruct() {
		if($this->render) {
			$this->view->render();
		}
	}	
	
}