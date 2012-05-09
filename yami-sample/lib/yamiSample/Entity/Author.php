<?php
namespace yamiSample\Entity;
use yami\ORM\Entity;

class Author extends Entity {
	
	protected static $tableName = 'author';
	protected static $ids = array('id');
	protected static $backend = 'default';
		
	public function getBooks() {
		
	}
	
}