<?php

include_once(__DIR__.'/sfile_get_contents.php');
include_once(__DIR__.'/sfile_put_contents.php');
function	get_json($filename) {
	// should build a mechanism for larger than 5mb files since this creates problems
	// for memory management
	if ( !file_exists($filename) ) {
		touch($filename);
		sfile_put_contents($filename,json_encode(array()));
	}
	return json_decode(sfile_get_contents($filename),true);
}

?>