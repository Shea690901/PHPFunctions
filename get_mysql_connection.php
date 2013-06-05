<?php 
/************************************************
 * MGW&A
 * title:	get mysql connection
 * 
 * description:
 * gets a mysql connection if we have an L1 password
 * 
 * parameters:
 * optionally takes L1 password, otherwise checks session
 */

/*************************************************
|	Scratch pad... all random file notes go here

[ key ______________________________________
[	+	addition
[	-	deletion
[	&	additional, but related requirements
[	!	constraint
[	^	suggestion
[	?	possibility or question
[	@	example
[	$	conclusion, the bottom line, a number
[	=	solution
[	~	for consideration
[
    + will want to allow multiple users at some point
*/

function	mgw_get_mysql_connection($password='', $db='') {
	//if ( !strlen($user) )
		$user	= "root";
	include(CONFIGS.'/mysql.php');
	$mysqli	= new mysqli('localhost', $user, openssl_decrypt($mgw_mysql_password, 'AES-256-ECB', sha1($password.$mgw_mysql_password_salt)));
	if ( strlen($db) )
		$mysqli->select_db($db);
	return $mysqli;
}
?>