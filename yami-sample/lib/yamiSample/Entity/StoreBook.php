<?php
namespace yamiSample\Entity;

use yami\Database\Sql\Condition;

use yami\ORM\Entity;

class StoreBook extends Entity {

	protected static $tableName = 'store_x_book';
	protected static $ids = array('book_id', 'store_id');
	protected static $backend = 'default';
	
	public static function byBook(Book $book) {
		return StoresBooks::select()->where('book_id={int:book_id}')->execute(array('book_id' => $book->id));
		//return StoresBooks::select()->where(Condition::make('book_id', $book->id))->execute();
	}
	
	public function getStore() {
		return new Store($this->store_id);
	}
}