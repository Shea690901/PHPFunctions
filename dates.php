<?php

function	time_since($timestamp) {
	if ( $timestamp > time() )
		return "Now";
	$val	= time()-$timestamp;
	if ( $val < 60 )
		return "<1m";
	else if ( $val < 3600 )
		return (int)($val/60)."m";
	else if ( $val < 3600*24 )
		return (int)($val/3600)."h";
	else if ( $val < 3600*24*7 )
		return (int)($val/(3600*24))."d";
	else if ( $val < 3600*24*7*4 )
		return (int)($val/(3600*24*7))."w";
	else if ( $val < 3600*24*365 )
		return (int)($val/(3600*24*7*4))."M";
	else
		return (int)($val/(3600*24*365))."y";
}
function	time_to($timestamp) {
	if ( $timestamp < time() )
		return "Now";
	$val	= $timestamp-time();
	if ( $val < 60 )
		return "<1m";
	else if ( $val < 3600 )
		return (int)($val/60)."m";
	else if ( $val < 3600*24 )
		return (int)($val/3600)."h";
	else if ( $val < 3600*24*7 )
		return (int)($val/(3600*24))."d";
	else if ( $val < 3600*24*7*4 )
		return (int)($val/(3600*24*7))."w";
	else if ( $val < 3600*24*365 )
		return (int)($val/(3600*24*7*4))."M";
	else
		return (int)($val/(3600*24*365))."y";
}
function	millitime() {
	$microtime	= preg_match("/\.([0-9]+)/",microtime(true),$matches);
	$timestamp	= time().str_pad(substr($matches[1],0,3),3,"0");
	return $timestamp;
}
function	realtime() {
	$microtime	= preg_match("/\.([0-9]+)/",microtime(true),$matches);
	$timestamp	= time().str_pad($matches[1],6,"0");
	return $timestamp;
}
?>