<?php
namespace yamiSample;
use yamiSample\Controller\Crud;

use yamiSample\Entity\Authors;
use yami\Router\Action\Controller;

class Store extends Crud {

	public $collection = '\yamiSample\Entity\Store';
	public $entity = '\yamiSample\Entity\Store';

	public function getCollection() {
		return '\yamiSample\Entity\Store';
	}

	public function getEntity() {
		return '\yamiSample\Entity\Store';
	}
}