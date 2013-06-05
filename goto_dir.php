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
	foreach ( $path as $dir ) {
		if ( !strlen($dir) )
			continue;
		if ( !is_dir($dir) )
			if ( !mkdir($dir) )
				return false;
		chdir($dir);
	}
	
	return true;
}

?>