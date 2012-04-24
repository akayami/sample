<?php
namespace yamiSample;
use yamiSample\Controller\Crud;

use yamiSample\Entity\Authors;
use yami\Router\Action\Controller;

class Author extends Crud {
	
	public $collection = '\yamiSample\Entity\Authors';
	public $entity = '\yamiSample\Entity\Author';
	
	public function getCollection() {
		return '\yamiSample\Entity\Authors';
	}
	
	public function getEntity() {
		return '\yamiSample\Entity\Author';
	}
	
} 