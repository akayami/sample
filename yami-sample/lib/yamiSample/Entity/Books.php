<?php
namespace yamiSample\Entity;

use yami\ORM\Collection;

class Books extends Collection {

	protected static $tableName = 'book';
	protected static $ids = array('id');
	protected static $backend = 'default';

	public function getEntity(array $data) {
		return new Book($data);
	}

}