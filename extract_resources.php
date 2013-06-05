<?php
/************************************************
 * MGW&A
 * title:	extract_resources
 * 
 * description:
 * extracts a resources from a text string
 * returns array of URL's, local file paths,
 * and MGW&A specific resources
 * 
 * parameters:
 * text string
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
*/

function	extract_resources($text) {
    //print $text;
    $urls	= array();
    $filepaths	= array();
    preg_match_all('/((http\:\/\/){1}(www\.)?([a-zA-Z0-9\-]+\.)+([a-zA-Z])+[^\s]+)/', $text, $matches);
    foreach ( $matches[0] as $match ) {
	if ( parse_url($match) )
	    array_push($urls, $match);
    }
	    
    // for windows
    preg_match_all('/([a-zA-Z]\:)([\/\\\][^\*\:\/\\\\|\>\<\?]+)+(\.[^\*\:\/\\\\|\>\<\?]+)?/', ($text), $matches);
    //preg_match_all('/([a-zA-Z]\:)([\\\][a-zA-Z]+)+/', $text, $matches);
    foreach ( $matches[0] as $match ) {
	if ( is_dir($match) || is_file($match) ) {
	    
	    array_push($filepaths, pathinfo($match));
	}
    }
    
    return array('urls'=>$urls, 'filepaths'=>$filepaths);
}
?>