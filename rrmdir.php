<?php
/************************************************
 * MGW&A
 * title:	unzip
 * 
 * description:
 * recursively remove a directory (when dir is not empty)
 * 
 * parameters:
 * target dir
 */


/* http://www.php.net/manual/en/function.rmdir.php */

function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
			}
		}
		reset($objects);
		rmdir($dir);
	}
}
?>