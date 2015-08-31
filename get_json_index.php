<?php

include_once(__DIR__.'/goto_dir.php');
include_once(__DIR__.'/sfile_put_contents.php');
function	get_json_index($filename,$index_key,$index_val,$options) {
	$default	= array(
		'key_size'=>2,
		'key_fn'=>'',
		'unique'=>true,
		'unique_key'=>'',
		'page'=>0,
		'count'=>50
	);

	$t	= microtime(true);
	$options	= array_merge($default,$options);
	$cwd	= getcwd();
	goto_dir($filename);
	if ( !is_dir($index_key) ) {
		mkdir($index_key);
		touch($index_key.'/index.json');
		sfile_put_contents($index_key.'/index.json','{}');
	}
	chdir($index_key);
	if ( $options['page'] > 0 ) {
		$page	= "-".$options['page'];
	}
	else
		$page	= '';
	$fname	= $index_key.'-'.substr((string)$index_val,0,$options['key_size']).$page.'.json';
	$contents	= sfile_get_contents($fname);
	$contents	= json_decode($contents,true);
	$contents	= $contents[(string)$index_val];
	$contents	= array_slice($contents,0,(int)$options['count']);
	chdir($cwd);
	$total_t	= microtime(true)-$t;
	return json_encode(array('time'=>$total_t,'contents'=>array($index_val=>$contents)),JSON_PRETTY_PRINT);
}

?>