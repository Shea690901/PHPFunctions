<?php
/************************************************
 * MGW&A
 * title:	goto dir
 * 
 * description:
 * ensures getcwd returns the input directory
 * 
 * parameters:
 * directory
 */

function	goto_dir($dir) {
	$path	= preg_split('/(\/|\\\)/', $dir);
	foreach ( $path as $i=>$dir ) {
		if ($i == 0 && stristr($dir,':') !== false) {
			chdir($dir);
			$num	= sizeof(preg_split('/(\/|\\\)/', getcwd()));
			while ( $num > 0 ){
				chdir('..');
				$num--;
			}
			continue;
		}
		if ( $dir == "." && $i == 0 )
			continue;
		if ( !strlen($dir) )
			continue;
		if ( !is_dir($dir) ) {
			if ( !mkdir($dir) )
				return false;
		}
		chdir($dir);
	}
	return true;
}

?>