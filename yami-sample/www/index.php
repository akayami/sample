<?php
use yami\Database\Sql\ConditionBlock;

use yami\Database\Sql\Condition;

use yami\Database\Sql\Field;

use yami\Database\Sql\Select;

use yami\Router\Route\Auto;

use yami\Router\Route\Standard;

use yami\ORM\Backend\Manager;
use yami\Router\Exception;
use yami\Router\Route\Simple;
use yami\Http\Request;
use yami\Router\Route\Regex as Regex;
use yami\Router\Controller;


$start = microtime(true);

include('../inc/includePath.inc.php');

require_once('autoload.inc.php');
require_once('main.conf.php');
@include('local.conf.php');

/** 
 * @var yami\Router\Controller
 */
$cont = Controller::getInstance();
$cont->addRoute(new Simple('/', 'yamiSample\Main', 'defaultAction'), 0);
$cont->addRoute(new Regex('#^/author/list(/)*#', 'yamiSample\Author', 'read'), 0);
$cont->addRoute(new Regex('#^/author/update(/)*#', 'yamiSample\Author', 'update'), 0);
$cont->addRoute(new Regex('#^/author/delete(/)*#', 'yamiSample\Author', 'delete'), 0);
$cont->addRoute(new Regex('#^/author/add(/)*#', 'yamiSample\Author', 'create'), 0);

$cont->addRoute(new Regex('#^/book/list(/)*#', 'yamiSample\Book', 'read'), 0);
$cont->addRoute(new Regex('#^/book/update(/)*#', 'yamiSample\Book', 'update'), 0);
$cont->addRoute(new Regex('#^/book/delete(/)*#', 'yamiSample\Book', 'delete'), 0);
$cont->addRoute(new Regex('#^/book/add(/)*#', 'yamiSample\Book', 'create'), 0);


$cont->addRoute(new Regex('#^/store/list(/)*#', 'yamiSample\Store', 'read'), 0);
$cont->addRoute(new Regex('#^/store/update(/)*#', 'yamiSample\Store', 'update'), 0);
$cont->addRoute(new Regex('#^/store/delete(/)*#', 'yamiSample\Store', 'delete'), 0);
$cont->addRoute(new Regex('#^/store/add(/)*#', 'yamiSample\Store', 'create'), 0);

$cont->addRoute(new Regex('#^/abc/query/(?<bbb>.+)/(?<perpage>.+)#', 'yamiSample\Main', 'specialAction'), 2);
$cont->addRoute(new Regex('#^/error/(?<code>\d+)$#', 'yamiSample\Error', 'handle'), 1000);
$cont->addRoute(new Auto('\yamiSample'), 1001);


//$cont->route(Request::getInstance()->REQUEST_URI);

try {
	$cont->route(Request::getInstance()->REQUEST_URI);
} catch(\Exception $e) {
	Request::getInstance()->error = $e;
	$cont->route('/error/'.$e->getCode());
}

$block = new ConditionBlock();
$block->add("table.`somefield` LIKE {str:placeholder}");
$block->add("`somefield` LIKE '%cock%'");

$subBlock = new ConditionBlock('OR');
$subBlock->add("table.`somefield` LIKE {str:placeholder}");
$subBlock->add("table.`somefield` LIKE {str:placeholder}");
$block->add($subBlock);
//echo $block;




// $condition = new Condition();
// $condition->add("table.`somefield` LIKE {str:placeholder}")
// $condition = new Condition("table.`somefield` LIKE {str:placeholder}");
// print_r($condition);
// $condition = new Condition("`somefield` LIKE '%cock%'");
// print_r($condition);




$select = new Select();
$select->field('table.somefield as field')->field('table.anotherfield as field1');
$select->from('table');
$select->where('(somefield=1 AND someField=2 AND (a=5 or a=6))');
// echo "<pre>";
// print_r($select);
//echo $select;



$end = microtime(true);
echo $end - $start;
echo "<br>";
echo memory_get_peak_usage(true);