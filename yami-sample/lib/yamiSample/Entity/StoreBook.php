<?php
namespace yamiSample\Entity;

use yami\ORM\Entity;

class StoreBook extends Entity {

	protected static $tableName = 'store_x_book';
	protected static $ids = array('book_id', 'store_id');
	protected static $backend = 'default';
	
}