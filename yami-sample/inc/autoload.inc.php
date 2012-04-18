<?php
@include('/tmp/classMap.php');
function sp_autoload($name) {
	global $_classMapFile;
	if(isset($_classMapFile[$name])) {
		require($_classMapFile[$name]);
	} else {
		$path = preg_replace('/_|\\\/', DIRECTORY_SEPARATOR, $name).'.php';
		require($path);
	}
}
spl_autoload_register('sp_autoload');
