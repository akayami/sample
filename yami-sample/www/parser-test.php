<?php
// use yami\Database\Sql\Condition;

// use yami\Database\Sql\ConditionBlock;

// use yami\Database\Sql\Field;

// use yami\Database\Sql\Table;

use yami\Database\Sql2\Select;

use yami\Redis\Manager;

$start = microtime(true);

include('../inc/includePath.inc.php');

require_once('autoload.inc.php');
require_once('main.conf.php');
@include('local.conf.php');

//$q = "SELECT `table`.`field` as a FROM Home JOIN Something USING id WHERE id = (SELECT user_id from users where email like '%cock?cock.com%') LIMIT 10 OFFSET 20 ORDER BY id";
// $q = 'SELECT `field1` as a, field2 as b, field3 FROM `home` as a WHERE field1 LIKE \'{int:test}\' AND (field2 LIKE \'%cock%\' OR crap=1)';
// $q = 'SELECT `field1` as a, field2 as b, field3 FROM `home` as a WHERE field1 LIKE \'{int:test}\' AND (field2 LIKE \'%cock%\' OR crap=('.$q.')';

//$q = 'SELECT * FROM table WHERE a=1 ORDER BY c DESC LIMIT 10 OFFSET 20';
//$q = 'SELECT * FROM table WHERE a=1 ORDER BY c DESC, RAND() LIMIT 20, 10';
$q = 'SELECT schema.`table`.c as b, sum(id + 5 * (5 + 5)) as p FROM schema.table WHERE a=1 GROUP BY c HAVING p > 10 ORDER BY p DESC';
//$parser = new PHPSQLParser($q);
// print_r($parser->parsed);
// exit;

$parser = new PHPSQLParser($q);
print_r($parser->parsed);
exit;
$q = new Select($q);
//print_r($q);
echo $q;
exit;
//exit;
//$sql = new Select($q);

$parser = new PHPSQLParser($q);

if(isset($parser->parsed)) {
	//print_r($parser->parsed);exit;
// 	$sql = new Select($parser->parsed);
}
echo $sql;
// /print_r($sql);


function parseQuery($struc) {
	$sql = new Select();
	foreach($struc['SELECT'] as $field) {		
		$sql->field(parseField($field));
	}
	foreach($struc['FROM'] as $table) {
		$t = new Table($table['table']);
		$t->alias($table['alias']['name']);
		$sql->from($t);
	}
	if(isset($struc['WHERE'])) {
		$sql->where(parseWhereExpression($struc['WHERE']));
	}
	return $sql;
}

function parseField(array $field) {
	switch($field['expr_type']) {
		case 'colref':
			$f = new Field($field['base_expr']);
			break;
		case 'expression':
			if(count($field['sub_tree']) > 1) {
					throw new Exception('Unsupported mulit expression field');
			}
			
			switch($field['sub_tree'][0]['expr_type']) {
				case 'subquery':
					$f = new Field(parseQuery($field['sub_tree'][0]['sub_tree']));
					break;
				default:
					throw new \Exception('unsupported field type expression');
			}
			break;
		default:
			throw new \Exception('unsupported field type:'.$field['expr_type']);
	}
	if(isset($field['alias'])) {
		$f->alias($field['alias']['name']);
	}
	return $f;
}

function parseWhereExpression(array $expr) {
	$condBlock = new ConditionBlock();
	$cond = null;
	$lastOp = null;
	foreach($expr as $chunk) {
		switch($chunk['expr_type']) {
			case 'colref':				
				$cond = new Condition();
				$cond->field($chunk['base_expr']);
				break;
			case 'operator':
				switch($lastOp) {
					case 'colref':						
						$cond->operator($chunk['base_expr']);
						break;
					case 'const':
						$condBlock->setLogicalOperator($chunk['base_expr']);
						break;
					default:
						throw new \Exception('unsupported operator context:'.$lastOp);
						
				}
				break;
			case 'const':
				$cond->value($chunk['base_expr']);
				$condBlock->add($cond);
				break;
			case 'operator':
				$condBlock->setLogicalOperator($chunk['base_expr']);
				break;
			case 'expression':
				$condBlock->add(parseWhereExpression($chunk['sub_tree']));
				break;
			case 'subquery':
				$cond->value(parseQuery($chunk['sub_tree']));
				$condBlock->add($cond);
				break;
			default: 
				throw new \Exception('unsuported expression type: '.$chunk['expr_type']);
		}
		$lastOp = $chunk['expr_type'];
	}
	return $condBlock;
}
