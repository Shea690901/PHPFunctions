<?php

include_once(__DIR__.'/rscandir.php');

function	get_directory_last_modified($directory) {
	if ( !is_dir($directory) )
		return 0;
	$files	= rscandir($directory);
	$mfiles	= array();
	$mtime	= 0;
	foreach ( $files as $file ) {
		if ( filemtime($file) > $mtime )
			$mtime	= filemtime($file);
	}

	return $mtime;
}

?>