<?php 
/************************************************
 * MGW&A
 * title:	random string
 * 
 * description:
 * generates a random n-length string
 * 
 * parameters:
 * length - number of characters in returned string
 */

function	mgw_rand_string($len) {
	$characters	= "`1234567890-=~!@#$%^&*()_+qwertyuiop[]\QWERTYUIOP{}|asdfghjkl;'ASDFGHJKL:\"zxcvbnm,./ZXCVBNM<>?";
	$numchars	= strlen($characters);
	$string		= '';
	for ( $i=0; $i<$len; $i++ )
		$string	.=	$characters[rand(0,$numchars)];
	return $string;
}

function	mgw_rand_filesafe_string($len) {
	$characters	= "1234567890qwertyuiopasdfklzxcvbnmQWERTYUIOPASDFHJKLZXCVBNM";
	$numchars	= strlen($characters);
	$string		= '';
	for ( $i=0; $i<$len; $i++ )
		$string	.=	$characters[rand(0,$numchars)];
	return $string;
}

?>