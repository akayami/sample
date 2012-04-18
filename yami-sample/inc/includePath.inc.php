<?php
$pieces = explode(DIRECTORY_SEPARATOR, __FILE__);
array_pop($pieces);
array_pop($pieces);
$_incRoot = implode(DIRECTORY_SEPARATOR, $pieces);
$_incPaths = array(
	'conf',
	'inc',
	'lib',
	'controllers',
	'views',
	'templates'
);
foreach($_incPaths as $key => $path) {
	$_incPaths[$key] = $_incRoot.'/'.$path;
}
$_incPaths[] = '/home/t_rakowski/git/yami/yami/lib';

set_include_path(implode(PATH_SEPARATOR, array_merge(explode(PATH_SEPARATOR, get_include_path()), $_incPaths)));