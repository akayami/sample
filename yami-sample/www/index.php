<?php
use yamiSample\I18n;

use yamiSample\ContextLevel\Geolocation;

use yamiSample\Filter;

use yamiSample\ContextLevel\Language;

use Bacon\Http\Request;
use Bacon\Router\Route\Simple;
use Bacon\Router\Route\Regex;
use Bacon\Router\Route\Auto;
use yamiSample\Router\Controller;



$start = microtime(true);

include('../inc/includePath.inc.php');

require_once('autoload.inc.php');
//require_once('dbonly.conf.php');
require_once('main.conf.php');
@include('local.conf.php');


// $oldHandler = set_error_handler(function($errno, $errstr, $errfile, $errline) {
//  	error_log($errno.':'.$errstr.' - [Line: '.$errline.'] '.$errfile);
//  	$bypass = array(2, 8); // Skip triggering on error type 2
//  	if(!in_array($errno, $bypass)) {
//  		throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
//  	}
// });

/**
 * @var Bacon\Router\Controller
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

/**
 *
 * @var I18n
 */
$i18n = new \yamiSample\I18n($lang, $country, $state, $city);


/**
 * This is defined for the view to wire itself into
 * @var array
 */
$content = array(
	'lang' => $lang,
	'country' => $country,
	'state' => $state,
	'city' => $city
);

$str = $lang.'_'.strtoupper($country);
setlocale(LC_ALL, $str.'.UTF-8');
bindtextdomain("default", "../locale");
textdomain("default");

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
	throw $e;
	ob_end_clean();
 	Request::getInstance()->error = $e;
 	$target = '/error/'.$e->getCode();
 	$cont->route($target);
}

$end = microtime(true);
echo $end - $start;
echo "<br>";
echo memory_get_peak_usage(true);