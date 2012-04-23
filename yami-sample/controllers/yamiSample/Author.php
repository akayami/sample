<?php
namespace yamiSample;
use yami\Router\Action\Controller;

class Author extends Controller {
	
	protected static $tableName = 'Author';
	protected static $ids = array('id');
	protected static $backendConfig = array(
			array('\yami\Mc\Manager' => 'default'),
			array('\yami\Database\Manager' => 'default')
	);
	
} 