<?php

include_once(__DIR__.'/goto_dir.php');
include_once(__DIR__.'/sfile_put_contents.php');
function	search_json_index($filename,$index_key,$index_val,$options) {
	$default	= array(
		'key_size'=>2,
		'key_fn'=>'',
		'unique'=>true,
		'unique_key'=>''
	);

	$options	= array_merge($default,$options);
	$cwd	= getcwd();
	goto_dir($filename);
	if ( !is_dir($index_key) ) {
		mkdir($index_key);
		touch($index_key.'/index.json');
		sfile_put_contents($index_key.'/index.json','{}');
	}
	chdir($index_key);
	$fname	= $index_key.'-'.substr((string)$index_val,0,$options['key_size']).'.json';
	$contents	= sfile_get_contents($fname);
	chdir($cwd);
	return $contents;
}

?>