<?php
namespace yamiSample\Entity;
use yami\ORM\Collection;

class Authors extends Collection {

	protected static $tableName = 'author';
	protected static $ids = array('id');
	protected static $backend = 'default';
	
	public function getEntity(array $data) {
		return new Author($data);
	}

}