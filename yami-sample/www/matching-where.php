<?php
use yami\Database\Sql\Where;

include('../inc/includePath.inc.php');

require_once('autoload.inc.php');
require_once('main.conf.php');
@include('local.conf.php');

$examples = array(
		"somefield=1 AND somefield=2 OR A=null AND b=whatever xor p=ass",
//		"somefield=1 AND someField=2 AND (a=15 or a=16 OR (a=115 AND a=116)) AND (a=25 or b=25 OR (a=225 AND a=226 OR (a=2225 AND a=2226)))"
);

print_r($examples);

echo "--------------\n";

foreach($examples as $subject) {
	$where = new Where($subject);
	
//	recursiveSplit($subject);
// 	/matchBlock($subject);
}

function recursiveSplit($string, $layer = 0) {
	preg_match_all("/\((([^()]*|(?R))*)\)/",$string,$matches);
	echo "\n{$layer}--------------\n";
    print_r($matches);
	// iterate thru matches and continue recursive split
	//recursiveSplit($matches[1])
// 	if(count($matches) > 1) {
// 		foreach($matches[0] as $i => $match) {
// 			//echo "\n".$matches[1][$i];
// 			recursiveSplit($matches[1][$i]);
// 		}
// 	} else {
// 		echo "\n---".$string;
// 	}
	
	
 	if (count($matches) > 1) {
 		$match = false;
 		for ($i = 0; $i < count($matches[1]); $i++) {
 			$match = true;
 			if (is_string($matches[1][$i]) && (strlen($matches[1][$i]) > 0)) {
 				
 						recursiveSplit($matches[1][$i], $layer + 1);
//  					if(($return = recursiveSplit($matches[1][$i], $layer + 1)) === false) {
//  						return $matches[1][$i];
//  					} else {
//  						echo "\n{$layer}--------------\n";
//  						echo "\n{$return}\n";
//  						echo str_replace($return, '*', $matches[1][$i]);
//  					}
 			} else {
 				echo "\n{$layer}:No Matches on ".$string;
 			}
 		}
 	} else {
 		echo "\n{$layer}:No Matches on ".$string;
 	}
 	if(!$match) {
 		return false;
 	}
}


// function matchBlock($block) {
// 	$regex = "#\((.+)\)#U";
// 	if(preg_match_all($regex, $block, $matches)) {
		
// 		print_r($matches);
				
// //		if(strlen($matches['block'])) {
// // 			echo "---------------\n";
// // 			print_r($matches['block']);
		
// // 			//matchBlock($matches['block']);
// // 			echo preg_replace('/.+/', '',$matches['block']);
// //		}	
// 	}
// }