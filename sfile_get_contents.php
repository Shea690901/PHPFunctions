<?php

function	sfile_get_contents($filename) {
	if ( !file_exists($filename) )
		return false;
/*
	if ( !file_exists(__DIR__.'/access.json') ) {
		touch(__DIR__.'/access.json');
		file_put_contents(__DIR__.'/access.json',array(
			'read'=>array(),
			'write'=>array()
		));
	}

	// check access file
	$table	= json_decode(file_get_contents(__DIR__.'/access.json'),true);
	if ( !array_key_exists(realpath($filename),$table['read']) ) {
		
		$table['read'][realpath($filename)] = 1;
		file_put_contents(__DIR__.'/access.json',json_encode($table));
		return file_get_contents($filename);
	}
	// write access file
	$table['read'][realpath($filename)]++;
	file_put_contents(__DIR__.'/access.json',json_encode($table));
	*/

	// locking
	$fp	= fopen($filename,"r");
	while ( !flock($fp, LOCK_SH) ) usleep(1);
	clearstatcache();
	$contents	= fread($fp,filesize($filename));
	flock($fp, LOCK_UN);
	fclose($fp);

	/*
	// write access file
	$table['read'][realpath($filename)]--;
	if ( $table['read'][realpath($filename)] == 0 )
		unset($table['read'][realpath($filename)]);
	file_put_contents(__DIR__.'/access.json',json_encode($table));
	*/
	
	return $contents;
}	

?>