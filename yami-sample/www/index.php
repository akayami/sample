<?php
use yami\Router\Exception;

use yami\Router\Route\Simple;

use yami\Http\Request;

include('../inc/includePath.inc.php');

$start = microtime(true);
require_once('autoload.inc.php');
require_once('main.conf.php');
@include('local.conf.php');


use yami\Router\Route\Regex as Regex;
use yami\Router\Controller;


//Request::getInstance()->aaa = 5;

/** 
 * @var yami\Router\Controller
 */
$cont = Controller::getInstance();
$cont->addRoute(new Simple('/', 'yamiSample\Main', 'defaultAction'), 0);
$cont->addRoute(new Regex('#^/abc/query/(?<bbb>.+)/(?<perpage>.+)#', '\test\someController', 'someAction'), 1);


$cont->route(Request::getInstance()->REQUEST_URI);

// try {
// 	$cont->route(Request::getInstance()->REQUEST_URI);
// } catch(Exception $e) {
// 	$cont->route('/error/404');
// }

$end = microtime(true);
echo $end - $start;
echo "<br>";
echo memory_get_peak_usage(true);