<?php
/*
 * Storage Config
 */
$config['db'] = array( 
	'default' => array ( 
		'master'  => array(
			'servers' => array(
				array(
					'hostname' => 'localhost'
				)
			),
			'shared' => array(
				'socket' => '/var/run/mysqld/mysqld.sock',
				'username' => 'root', 
				'password' => '',
				'dbname' => 'bookstore',
				'persistent' => false,
				'adapter' => 'yami\Database\Adapter\Mysqli'
			)
		),
		'slave' => array(
			'servers' => array(
				array(
					'hostname' => 'localhost'
				)
			),
			'shared' => array(
				'socket' => '/var/run/mysqld/mysqld.sock',
				'username' => 'readonly', 
				'password' => '',
				'dbname' => 'bookstore',
				'persistent' => false,
				'adapter' => 'yami\Database\Adapter\Mysqli'
			)
		)
	)
);

$config['redis'] = array(
	'default' => array(
		'master' => array(
			'servers' => array(
				array('hostname' => 'localhost')
			),
			'shared' => array(
				'port' => 6379,
				'timeout' => 2,
				'persistent' => false
			)
		),
		'slave' => array(
			'servers' => array(
				array('hostname' => 'localhost'),
				array('hostname' => 'localhost')
			),
			'shared' => array(			
				'port' => 6379,
				'timeout' => 2,
				'persistent' => true
			)
		)
	)
);


/*
 * Memcached Config
 */
$config['mc'] = array(
	'default' => array(
		array('127.0.0.1', 11211)
	)
);


/*
 * Backend Configuration
 */

// $config['backend'] = array(
// 	'default' => array(
// 		'manager' => 'yami\Mc\Manager',
// 		'backend' => 'yami\ORM\Backend\Mc',
// 		'namespace' => 'default',
// 		'child' => array(
// 			'manager' => 'yami\Database\Manager',
// 			'backend' => 'yami\ORM\Backend\Db',
// 			'namespace' => 'default',				
// 		)
// 	)
// );


$config['backend'] = array(
		'default' => array(
				'manager' => 'yami\Redis\Manager',
				'backend' => 'yami\ORM\Backend\Redis',
				'namespace' => 'default',
				'child' => array(
						'manager' => 'yami\Database\Manager',
						'backend' => 'yami\ORM\Backend\Db',
						'namespace' => 'default',
				)
		)
);

