<?php

include_once(__DIR__.'/sfile_put_contents.php');
function	set_json($filename,$json) {
	// should build a mechanism for larger than 5mb files since this creates problems
	// for memory management
	if ( !file_exists($filename) ) {
		touch($filename);
		sfile_put_contents($filename,'{}');
	}
	sfile_put_contents($filename,json_encode($json,JSON_PRETTY_PRINT));
}

?>