<?php
namespace yami\Database\Sql;
// use yami\Database\Sql\Table;

// use yami\Database\Sql\Select;

$start = microtime(true);

include('../inc/includePath.inc.php');

require_once('autoload.inc.php');
require_once('main.conf.php');
@include('local.conf.php');

// $q = "SELECT * FROM ModelMedia WHERE model_id IN ({int:model_id}) AND status = 'active' AND type='image'";
// $s = new Select($q);
// print_r($s->structure->parsed);
// echo $s;exit;



$s = new Select('SELECT * FROM Model');
$s->unsetTable()->table("Model JOIN ModelCategoryPair ON ModelCategoryPair.model_id=Model.model_id AND ModelCategoryPair.mcat_id='{int:categoryId}'");
print_r($s->structure->parsed);
echo $s;
exit;


$q = "SELECT * FROM asb WHERE screen LIKE {str:crap} LIMIT 5 OFFSET {int:sds}";
$s = new Select($q);
echo $s;exit;
// $parser = new \PHPSQLParser($q);
// print_r($parser->parsed);exit;

$q = new Select("SELECT * FROM (SELECT * FROM ModelMedia WHERE model_id = 5 AND model_id IN ({int:model_id}) AND status = 'active' ORDER BY rand()) as t GROUP BY model_id");

print_r($q);
echo $q;
exit;

// $q = new Select('Select `field` from table1 JOIN table2 ON table2.id=table1.id');
// //print_r($q);
// echo $q;
// exit;

// $q = new Select();
// $q->addField(new Field('*'));
// $q->addTable(new Table('table1', 'tableAlias1'));
// $q->addTable(new Table('table2', 'alias2', 'JOIN', new Condition(new ConditionField('table1.someField'), new Operator('='), new ConditionField('table2.someField'))));
// $q->addCondition(new Condition(new ConditionField('table1.someField'), new Operator('LIKE'), "%cock%"));
// echo $q->__toString();
// exit;
// $c1 = new ConditionBlock('OR');
// $c1->add(new Condition( new ConditionField('Field'), new Operator('='), 5))->add(new Condition( new ConditionField('Field'), new Operator('='), 4));
// $q->addCondition($c1);
// $q->addAggregate(new Aggregate('table1.someField'));
// $q->addHaving(new Condition(new ConditionField('someField'), new Operator('>'), '10'));
// $q->addOrder(new Order('someField'));
// $q->addLimit(new Limit(50));

// $p = 'tom';
// $test(&$p);

// function test($a) {
// 	echo $a;
// }


// echo $q;
// echo "\n\n";
// $q1 = new Select($q->__toString());
// echo $q1;
// echo "\n\n";
// exit;

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
$q->__toString();
exit;
//exit;
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
