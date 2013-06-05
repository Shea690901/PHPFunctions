<?php
/************************************************
 * MGW&A
 * title:	add remote
 * 
 * description:
 * takes a remote website enabled with FTP
 * and maintains an active sync connection locally
 * 
 * requires:
 * local path string
 * ftp string
 */
if ( sizeof($argv) < 2 )
   die("did not include local path");
   
$args	= array();
if ( sizeof($argv) > 2 )
    $args	= array_slice($argv, 2);
	
$xml	= file_get_contents('startPHP.xml');
$xml	= new SimpleXMLElement('startPHP.xml', NULL, true);
$php	= $xml->Actions->Exec->Arguments;
$php	= $argv[1].' '.implode(' ', $args);
$xml->Actions->Exec->Arguments	= $php;

include(__DIR__.'/random_string.php');
$filename	= mgw_rand_filesafe_string(8);
$xml->asXML($filename);
 
 // mysqli
exec('schtasks /create /XML '.$filename.' /tn phptaskname');
unlink($filename);
?>