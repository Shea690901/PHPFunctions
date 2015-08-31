<?php

include_once(__DIR__.'/sfile_get_contents.php');
include_once(__DIR__.'/sfile_put_contents.php');
function	deep_json_decode($string) {
	if ( !is_array($string) )
		$json	= json_decode($string,true);
	else
		$json	= $string;
	if ( $json == NULL )
		return $string;
	foreach ( $json as $k=>$v ) {
		if ( is_string($json[$k]) )
			$json[$k]	= deep_json_decode($json[$k]);
	}
	$string	= $json;
	return $string;
}

?>