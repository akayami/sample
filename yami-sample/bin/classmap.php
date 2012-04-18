<?php

/*
 * Usage:
 * php classmap.php "/Users/tomasz/dev/workspace/sample/lib/" "/Users/tomasz/dev/workspace/spl/lib" > /tmp/classMap.php
 * 
 * pass a list of directories to be scanned. At the end, pipe the output into the file you want to use.
 */

$filename = array_shift($argv);
$dirs = $argv;
$out = array();

foreach($argv as $dir) {
	$out = array_merge($out, scanForClasses(realpath($dir)));
}

echo "<?php\n";
echo '$_classMapFile = array('."\n";
foreach($out as $key => $val) {
	echo '\''.$key.'\' => \''.$val.'\','."\n";
}
echo ");\n?>"."\n";

function scanForClasses($dir) {
	$out = array();
	$dir = new DirectoryIterator($dir);
	foreach($dir as $fileinfo) {
		if($fileinfo->isFile()) {
			if($fileinfo->getExtension() == 'php') {
				$con = file_get_contents($fileinfo->getPathname());
				$ns = '';
				if(preg_match('/namespace (.+);\n/', $con, $matches)) {
					if(isset($matches[1])) {
						$ns = $matches[1];
					}
				}
				//echo $con;
				if(preg_match('/(class|interface)\s+(\w+)\s+/', $con, $matches)) {;
					$out[$ns.'\\'.$matches[2]] = $fileinfo->getPathname();
				}
			}
			//echo $fileinfo->getFilename();
		} else {
			if(!$fileinfo->isDot()) {
				$out = array_merge($out, scanForClasses($fileinfo->getPathname()));
			}
		}
	}
	return $out;
}
?>