<?php
use yamiSample\ContextLevel\Geolocation;

use yamiSample\Filter;

use yamiSample\ContextLevel\Language;

use yami\Http\Request;
use yami\Router\Route\Simple;
use yami\Router\Route\Regex;
use yami\Router\Route\Auto;
use yamiSample\Router\Controller;

$oldHandler = set_error_handler(function($errno, $errstr, $errfile, $errline) {
	$bypass = array(2); // Skip triggering on error type 2
	if(!in_array($errno, $bypass)) {
		throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
	}
});

$start = microtime(true);

include('../inc/includePath.inc.php');

require_once('autoload.inc.php');
//require_once('dbonly.conf.php');
require_once('main.conf.php');
@include('local.conf.php');

/** 
 * @var yami\Router\Controller
 */
$cont = Controller::getInstance();
require('whitelabel.inc.php');			// Bootstrapping an imaginary White label

/**
 * Bootstrapping Language & Location Handling
 */
$uri = Request::getInstance()->REQUEST_URI;
$parts = explode('/', $uri);

if($count = preg_match('#^(?P<lang>\w{2})(?:\:(?P<country>\w{2})(?:-(?P<state>\w{2})(?:-(?P<city>\w+))?)?)?$#', $parts[1], $matches)) {
	$prefix = $matches[0];
	if(isset($matches['lang'])) {
		$cont->addFilter(new Filter($matches['lang']));
	}
	$lang = isset($matches['lang']) ? $matches['lang'] : null;
	$country = isset($matches['country']) ? $matches['country'] : null;
	$state = isset($matches['state']) ? $matches['state'] : null;
	$city = isset($matches['city']) ? $matches['city'] : null;
	array_shift($parts);
	array_shift($parts);
	$uri = '/'.implode('/', $parts);
} else {
	$lang = 'en';
	$country = 'us';
	$state = 'qc';
	$city = 'montreal';
	$uri = Request::getInstance()->REQUEST_URI;
}

$c = Language::make($lang);
$c->append(Geolocation::make($country, $state, $city));

$cont->setContext($c);

/**
 * End of Language & Location Bootstrap
 */

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

try {
	$cont->route($uri);
} catch(\Exception $e) {
// 	echo $e->getPrevious()->getMessage();
// 	throw $e->getPrevious();
 	Request::getInstance()->error = $e;
 	$cont->route('/error/'.$e->getCode());
}

$end = microtime(true);
echo $end - $start;
echo "<br>";
echo memory_get_peak_usage(true);