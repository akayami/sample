<?php
namespace yamiSample\Entity;

use yami\ORM\Collection;

class StoresBooks extends Collection {

	protected static $tableName = 'store_x_book';
	protected static $ids = array('book_id', 'store_id');
	protected static $backend = 'default';

	public function getEntity(array $data) {
		return new StoreBook($data);
	}

}