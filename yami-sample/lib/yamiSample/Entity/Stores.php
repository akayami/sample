<?php
namespace yamiSample\Entity;

use yami\ORM\Collection;

class Stores extends Collection {

	protected static $tableName = 'store';
	protected static $ids = array('id');
	protected static $backend = 'default';

	public function getEntity(array $data) {
		return new Store($data);
	}

}