<?php

include_once(__DIR__.'/rscandir.php');

function	get_modified_files_since($directory, $time) {
	if ( !is_dir($directory) )
		return array();
	$files	= rscandir($directory);
	$mfiles	= array();
	foreach ( $files as $file ) {
		if ( filemtime($file) > $time )
			array_push($mfiles, $file);
	}

	return $mfiles;
}

?>