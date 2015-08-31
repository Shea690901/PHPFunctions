<?php

include_once(__DIR__.'/goto_dir.php');
include_once(__DIR__.'/data.php');
include_once(__DIR__.'/sfile_put_contents.php');
function	has_document($filename,$index_key,$document_name) {
	$cwd	= getcwd();
	if ( !is_dir($index_key) ) {
		mkdir($index_key);
		touch($index_key.'/index.json');
		sfile_put_contents($index_key.'/index.json','{"keys":{}, "count":0,"files":{}}');
	}
	chdir($index_key);
	if ( !file_exists('index-sources.json') ) {
		touch('index-sources.json');
		file_put_contents('index-sources.json','{}');
	}
	$sources	= get_json('index-sources.json');
	chdir($cwd);
	return (array_search($document_name,$sources)!==false);
}
function	set_json_index($filename, $json, $index_key, $options) {
	$default	= array(
		'key_size'=>2,
		'key_fn'=>'',
		'unique'=>true,
		'key_limit'=>100,
		'unique_key'=>'',
		'source'=>'', 
		'unique_source'=>true,
		'status'=>''
	);

	$options	= array_merge($default,$options);
	$cwd	= getcwd();
	goto_dir($filename);
	$pi	= pathinfo($filename);

	if ( !is_dir($index_key) ) {
		mkdir($index_key);
		touch($index_key.'/index.json');
		sfile_put_contents($index_key.'/index.json','{"keys":{}, "count":0,"files":{}}');
	}
	chdir($index_key);

	if ( is_array($options['source']) || strlen($options['source']) > 0 ) {
		if ( !file_exists('index-sources.json') ) {
			touch('index-sources.json');
			file_put_contents('index-sources.json','{}');
		}
		$sources	= get_json('index-sources.json');
		if ( $options['unique_source'] ) {
			if ( is_array($options['source']) ) {
				foreach ( $options['source'] as $source ) {
					if ( array_search($source, $sources) !== false ) {
						chdir($cwd);
						return;
					}
					else
						array_push($sources,$source);
				}
			}
			else if ( array_search($options['source'], $sources) !== false )
				return;
			else
				array_push($sources,$options['source']);

			set_json('index-sources.json',$sources);
		}
		
	}
	$index_json	= array_merge(get_json('index.json'),get_json('index-files.json'));

	$filearr	= array();
	$filecarr	= array();
	$fileuarr	= array();
	foreach ( $json as $k=>$v ) {
		if ( !is_string($options['key_fn']) ) {
			$fn	= $options['key_fn'];
			$key	= $fn($k,$v);
			if ( $key === false )
				continue;
		}
		else
			$key	= $v[$index_key];

		if ( !is_array($key) )
			$key	= array($key);
		$keys	= $key;
		foreach ( $keys as $key ) {
			$page	= "";
			$fname	= $index_key.'-'.substr(strtolower((string)$key),0,$options['key_size']).$page.'.json';
			$fname_base	= $index_key.'-'.substr(strtolower((string)$key),0,$options['key_size']);
			if ( array_key_exists($fname, $index_json['files']) && $index_json['files'][$fname]['count'] > $options['key_limit'] ) {
				$idx	= 1;
				$page	= "-".$idx;
				$fname	= $index_key.'-'.substr(strtolower((string)$key),0,$options['key_size']).$page.'.json';
				while (array_key_exists($fname, $index_json['files']) && $index_json['files'][$fname]['count'] > $options['key_limit']) {
					$idx++;
					$page	= "-".$idx;
					$fname	= $index_key.'-'.substr(strtolower((string)$key),0,$options['key_size']).$page.'.json';
				}
			}

			if ( !file_exists($fname) ) {
				touch($fname);
				sfile_put_contents($fname,'{}');
			}

			if ( !array_key_exists($fname, $filearr) )
				$filearr[$fname]	= 0;
			
			if ( $filearr[$fname] == 0 || !array_key_exists($fname,$filecarr) )
				$filecarr[$fname]	= json_decode(sfile_get_contents($fname),true);

			$j	= $filecarr[$fname];

			if ( !array_key_exists($fname, $index_json['files']) ) {
				$index_json['files'][$fname]	= array(
					'count'=>0,
					'last_update'=>time()
				);
			}
			if ( !array_key_exists($key, $index_json['keys']) )
				$index_json['keys'][$key]	= array(
					'count'=>0,
					'last_update'=>time(),
					'file'=>$fname
				);

			$inserted=false;
			if ( !$options['unique'] ) {
				if ( !array_key_exists($key, $j) ) 
					$j[$key]	= array();
				if ( strlen($options['unique_key']) > 0 ) {
					if ( !is_dir('uniques') )
						mkdir('uniques');
					if ( !file_exists('uniques/'.$fname_base.'-uniques.json') ) {
						touch('uniques/'.$fname_base.'-uniques.json');
						sfile_put_contents('uniques/'.$fname_base.'-uniques.json',json_encode($j));	
					}
					$json	= get_json('uniques/'.$fname_base.'-uniques.json');
					if ( array_search($v[$options['unique_key']], $json[$key]) === false ) {
						array_push($json[$key],$v[$options['unique_key']]);
						set_json('uniques/'.$fname_base.'-uniques.json',$json);
						$inserted=true;
						array_push($j[$key], $v);
					}
				}
				else {
					$inserted=true;
					array_push($j[$key], $v);
				}

			}
			else {
				$inserted=true;
				$j[$key]	= $v;
			}

			if ( $inserted ) {
				$index_json['files'][$fname]['count']++;
				$index_json['keys'][$key]['count']++;
				$index_json['count']++;
				$filearr[$fname]++;
			}

			$filecarr[$fname]	= $j;
			if ( $filearr[$fname] >= 5 ) {
				$filearr[$fname]	= 0;
				unset($filecarr[$fname]);
				sfile_put_contents($fname,json_encode($j,JSON_PRETTY_PRINT));
			}
		}
	}

	foreach ( $filecarr as $f=>$junk ) {
		if ( $filearr[$f] > 0 )
			sfile_put_contents($f,json_encode($filecarr[$f],JSON_PRETTY_PRINT));
		$filearr[$f]	= 0;
		unset($filecarr[$f]);
	}

	$index_copy	= $index_json;
	unset($index_json['files']);
	unset($index_copy['keys']);
	$index_json['options']	= $options;
	set_json('index.json',$index_json);
	set_json('index-files.json',$index_copy);

	chdir($cwd);
}

?>