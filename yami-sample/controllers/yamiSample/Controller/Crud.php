<?php
namespace yamiSample\Controller;
use Bacon\Http\Request;
use yamiSample\Author;

abstract class Crud extends Standard {
	
	/**
	 * 
	 * @var Request
	 */
	protected $request;
	
	public function __construct($action) {
		parent::__construct($action);
		$this->request = Request::getInstance(); 
	}
	
	abstract function getEntity();
	abstract function getCollection();
	
	public function read() {
		$col = $this->getCollection();
		$this->view->data = $col::select()->execute();
		$this->view->setActionName('yamiSample/Crud/read');
	}
	
	public function update() {
		$entity = $this->getEntity();
		if($this->request->get('action') == 'update') {
			try {
				$data = $this->request->get('data');
				$a = new $entity();
				foreach($data as $key => $data) {
					$a[$key] = $data;
				}
				$a = $a->update();
			} catch(\Exception $e) {
				$a = new $entity($this->request->get('id'));
			}
		} else {
			$a = new $entity($this->request->get('id'));
		}
		$this->view->data = $a;
		$this->view->structure = $entity::getStructure();
		$this->view->setActionName('yamiSample/Crud/update');
	}
	
	public function create() {
		$entity = $this->getEntity();
		if($this->request->get('action') == "insert") {
			$a = new $entity($this->request->get('data'));
			$a->insert();
		}
		$this->view->structure = $entity::getStructure();
		$this->view->setActionName('yamiSample/Crud/add');
	}
	
	public function delete() {
		$a = $this->getEntity();
		$author = $a::byId($this->request->id);
		$author->delete();
		$this->read();				
	}
	
}