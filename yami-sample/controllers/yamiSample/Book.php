<?php
namespace yamiSample;
use yamiSample\Entity\Stores;

use yamiSample\Entity\StoreBook;

use yamiSample\Entity\Book as BookEntity;

use yamiSample\Controller\Crud;

use yamiSample\Entity\Authors;
use yami\Router\Action\Controller;

class Book extends Crud {

	public $collection = '\yamiSample\Entity\Books';
	public $entity = '\yamiSample\Entity\Book';
	
	public function getCollection() {
		return '\yamiSample\Entity\Books';
	}
	
	public function getEntity() {
		return '\yamiSample\Entity\Book';
	}

	public function update() {
		if($this->request->has('sub-action')) {
			switch ($this->request->get('sub-action')) {
				case 'addStore':
					$o = new StoreBook($this->request->get('item'));
					$o->insert();
					break;
				case 'updateStore':
					$o = new StoreBook($this->request->get('item'));
					$o->update();
					$item = $this->request->get('item');
					$this->view->storeData = StoreBook::byId(array('book_id' => $item['book_id'], 'store_id' => $item['store_id']));
					break;
				case 'removeStore':
					$o = StoreBook::byId(array('book_id' => $this->request->get('book_id'), 'store_id' => $this->request->get('store_id')));
					$o->delete();
					break;
				case 'editStore':
					$this->view->storeData = StoreBook::byId(array('book_id' => $this->request->get('book_id'), 'store_id' => $this->request->get('store_id')));
					break;
			}
		}
		try {		
			BookEntity::getBackend()->beginTransaction();
			$book = new BookEntity($this->request->get('id'));
			$book->increment(array('view_counter' =>  1));
			BookEntity::getBackend()->commitTransaction();
		} catch(\Exception $e) {
			//throw $e;
			BookEntity::getBackend()->rollbackTransaction();
			error_log('rollback');
		}
	
		parent::update();
		$this->view->distribution = StoreBook::byBook($this->view->data);
		$this->view->stores = Stores::getAll();
		$this->view->setActionName('yamiSample/Book/update');
		//$this->setView('update');
	}	
	
} 