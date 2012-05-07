<?php
// use yami\Database\Sql\Condition;

// use yami\Database\Sql\ConditionBlock;

// use yami\Database\Sql\Field;

// use yami\Database\Sql\Table;

use yami\Database\Sql2\Condition;

use yami\Database\Sql2\Select;

use yami\Redis\Manager;

$start = microtime(true);

include('../inc/includePath.inc.php');

require_once('autoload.inc.php');
require_once('main.conf.php');
@include('local.conf.php');


// $parser = new PHPSQLParser("GROUP BY a, b, table.c");
// print_r($parser->parsed);
// //exit;

// $parser = new PHPSQLParser("ORDER BY a ASC, b DESC, table.c ASC");
// print_r($parser->parsed);
// exit;


//$q2 = new Select();
//$q2->order('p desc')->group('p');
//$q2->field('*')->table('table')->where('id=5 and cock like \'large\' and (a=5 and b=6)')->where('b=5')->limit('20 OFFSET 10')->group('p')->having('p > 5')->order('p DESC');
//echo $q2;
//exit;

//$q = "SELECT `table`.`field` as a FROM Home JOIN Something USING id WHERE id = (SELECT user_id from users where email like '%cock?cock.com%') LIMIT 10 OFFSET 20 ORDER BY id";
$q = 'SELECT `field1` as a, field2 as b, field3 FROM `home` as a WHERE field1 LIKE \'{int:test}\' AND (field2 LIKE \'%cock%\' OR crap=1)';
$q = 'SELECT `field1` as a, field2 as b, field3 FROM `home` as a WHERE field1 LIKE \'{int:test}\' AND (field2 LIKE \'%cock%\' OR crap=('.$q.')';

//$q = 'SELECT * FROM table WHERE a=1 ORDER BY c DESC LIMIT 10 OFFSET 20';
//$q = 'SELECT * FROM table WHERE a=1 ORDER BY c DESC, RAND() LIMIT 20, 10';
//$q = 'SELECT schema.`table`.c as b, sum(id + 5 * (5 + 5)) as p FROM schema.table JOIN table.x as aliasx ON a=b LEFT JOIN table.c USING joincolumn JOIN table.d JOIN (SELECT * FROM someOTHERTable) as ot WHERE a=1 GROUP BY c HAVING p > 10 ORDER BY p DESC LIMIT 10 OFFSET 20';
//$q = 'SELECT schema.`table`.c as b, sum(id + 5 * (5 + 5)) as p FROM schema.table JOIN table.x as aliasx ON a=b LEFT JOIN table.c USING joincolumn JOIN table.d JOIN (SELECT * FROM someOTHERTable) as ot WHERE a=1 GROUP BY c, `table`.a  HAVING p > 10 ORDER BY p DESC, `table`.a asc LIMIT 10,20';
//$parser = new PHPSQLParser($q);
// print_r($parser->parsed);
// exit;

// $parser = new PHPSQLParser($q);
// print_r($parser->parsed);
// exit;
$q = 'SELECT * FROM t1 UNION ALL SELECT * FROM t2 UNION ALL SELECT * FROM t3 UNION ALL SELECT field1, field2 FROM t4';		

$q = new Select($q);
//print_r($q);
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
