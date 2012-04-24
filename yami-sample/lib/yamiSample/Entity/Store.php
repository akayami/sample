<?php
namespace yamiSample\Entity;

use yami\ORM\Entity;

class Store extends Entity {
	
	protected static $tableName = 'store';
	protected static $ids = array('id');
	protected static $backend = 'default';
	
}