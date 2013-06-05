<?php
/************************************************
 * MGW&A
 * title:	scandir_recursive
 * 
 * description:
 * scandir but it picks up files in subdirectories
 * 
 * parameters:
 * directory
 *
 * todo:
 *
 * ensure that if there are cycles within the scanning
 * to prevent infinite loops from occurring (mostly with alias/virtual directories)
 */

// flat = true produces an array of strings,
//		e.g. path/to/dir
//		e.g. array(path)=>array(to)=>array(dir)=>file
function	rscandir($dir) {
    $files	= scandir($dir);
    $arr	= array();
    foreach ( $files as $file ) {
	if ( $file == '.' || $file == '..' )
	    continue;

	if ( is_dir($dir.'/'.$file) )
	    $arr	= array_merge($arr, rscandir($dir.'/'.$file));
	else
	    array_push($arr, $dir.'/'.$file);
    }
    
    return $arr;
}

?>