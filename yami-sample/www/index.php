<?php
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
$end = microtime(true);
echo $end - $start;
echo "<br>";
echo memory_get_peak_usage(true);