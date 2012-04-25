<?php
namespace yamiSample\Entity;

use yami\ORM\Entity;

class StoreBook extends Entity {

	protected static $tableName = 'store_x_book';
	protected static $ids = array('book_id', 'store_id');
	protected static $backend = 'default';
	
	public static function byBook(Book $book) {
		$q = 'SELECT * FROM '.static::getTableName().' WHERE book_id='.$book->id;
		$res = static::fromRecordset(static::getBackend()->select($q, array(static::getTableName() => static::getIds())));
		return $res;
	}
	
	public function getStore() {
		return new Store($this->store_id);
	}
}