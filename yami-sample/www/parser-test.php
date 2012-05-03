<?php
use yami\Database\Sql\Field;

use yami\Database\Sql\Table;

use yami\Database\Sql\Select;

use yami\Redis\Manager;

$start = microtime(true);

include('../inc/includePath.inc.php');

require_once('autoload.inc.php');
require_once('main.conf.php');
@include('local.conf.php');

$parser = new PHPSQLParser('SELECT `field1`, field2 as b, field3 FROM `home` as a WHERE field1 LIKE \''."{int:test}".'\' AND (field2 LIKE \'%cock%\' OR crap=1)');

if(isset($parser->parsed)) {

	$sql = new Select();
	foreach($parser->parsed['SELECT'] as $field) {
		$f = new Field($field['base_expr']);
		$f->alias($field['alias']['name']);
		$sql->field($f);
	}
	foreach($parser->parsed['FROM'] as $table) {
		$t = new Table($table['table']);
		$t->alias($table['alias']['name']);
		$sql->from($t);
	}
	print_r($sql);
	print_r($parser->parsed);
	echo $sql;
}
//print_r($r);