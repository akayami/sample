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
				'adapter' => 'yami\Database\Adapter\PDO'
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
				'adapter' => 'yami\Database\Adapter\PDO'
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




