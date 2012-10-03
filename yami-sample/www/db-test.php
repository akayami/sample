<?php
use yami\ORM\Backend\Db\UnbufferedRecordset;

use yami\ORM\Backend\Recordset\Db;

use yami\Database\Manager;

include('../inc/includePath.inc.php');

require_once('autoload.inc.php');
require_once('main-alt.conf.php');
@include('local.conf.php');

$conn = Manager::singleton()->get()->slave();

//print_r($conn);

$res = $conn->pquery('SELECT * FROM Model LIMIT 100');
$a = new UnbufferedRecordset($res);

echo $a->getResult()->length();

foreach($a as $key => $value) {
	print_r($value);	
}
//print_r($a);
//$a->current();
//error_log('test');

//print_r($a);

// foreach($a as $key => $value) {
// 	print_r($value);
// }

// while($row = $res->fetch()) {
// 	$b = $row;

// 	//echo "\n".memory_get_usage().' - .'.memory_get_peak_usage().' => '.(memory_get_usage() / memory_get_peak_usage()) * 100;
// }

// while($row = $res->fetch()) {
// 	$b = $row;
// 	print_r($b);
// 	//echo "\n".memory_get_usage().' - .'.memory_get_peak_usage().' => '.(memory_get_usage() / memory_get_peak_usage()) * 100;
// }

// //print_r($res);