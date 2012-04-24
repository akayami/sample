<?php
namespace yamiSample\Entity;

use yami\ORM\Entity;

class Book extends Entity {
	
	protected static $tableName = 'book';
	protected static $ids = array('id');
	protected static $backend = 'default';
	
}