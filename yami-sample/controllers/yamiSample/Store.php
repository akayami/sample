<?php
namespace yamiSample;
use yamiSample\Controller\Crud;

use yamiSample\Entity\Authors;
use Bacon\Router\Action\Controller;

class Store extends Crud {

	public $collection = '\yamiSample\Entity\Stores';
	public $entity = '\yamiSample\Entity\Store';

	public function getCollection() {
		return '\yamiSample\Entity\Stores';
	}

	public function getEntity() {
		return '\yamiSample\Entity\Store';
	}
}