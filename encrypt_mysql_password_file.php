<?php 
/************************************************
 * MGW&A
 * title:	encrypt mysql password file
 * 
 * description:
 * generates a new random salt, encrypts the mysql
 * password file with the new salt
 * 
 * requires:
 * mysql password
 * unlock password
 */
if ( sizeof($argv) < 2 )
	die("did not include mysql password");
if ( sizeof($argv) < 3 )
	die("did not include unlock password");
 
include(__DIR__.'/../Core/Accountant/Includes/random_string.php');
$new_salt	= mgw_rand_string(8);

$fp	= fopen('mysql.php', 'w+');
fwrite($fp, '<?php
	$mgw_mysql_password="'.addslashes(openssl_encrypt($argv[1], 'AES-256-ECB', sha1($argv[2].$new_salt))).'";
	$mgw_mysql_password_salt="'.$new_salt.'";
?>');
fclose($fp);
?>