<?php

function	sfile_put_contents($filename,$contents) {
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
	*/

	// check access file
	/*
	$table	= json_decode(file_get_contents(__DIR__.'/access.json'),true);
	if ( !array_key_exists(realpath($filename),$table['write']) ) {
		$table['write'][realpath($filename)]	= 1;
		file_put_contents(__DIR__.'/access.json',json_encode($table));
		return file_put_contents($filename,$contents);
	}
	// write access file
	$table['write'][realpath($filename)]++;
	file_put_contents(__DIR__.'/access.json',json_encode($table));
	*/

	// locking
	$fp	= fopen($filename,"c");
	while ( !flock($fp, LOCK_EX) ) usleep(1);
	ftruncate($fp, 0);
	$result	= fwrite($fp,$contents,strlen($contents));
	fflush($fp);
	flock($fp, LOCK_UN);
	fclose($fp);

	// write access file
	/*
	$table['write'][realpath($filename)]--;
	if ( $table['write'][realpath($filename)] == 0 )
		unset($table['write'][realpath($filename)]);
	file_put_contents(__DIR__.'/access.json',json_encode($table));
	*/
	return $result;
}

?>