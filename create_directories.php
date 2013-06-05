<?php
/************************************************
 * MGW&A
 * title:	create directories
 * 
 * description:
 * creates directories according to a build file
 * 
 * requires:
 * input of build order, each space (tab or otherwise)
 * counts as nested folder
 */

    if ( sizeof($argv) < 2 )
        die("did not include directory build file");
    if ( !file_exists($argv[1]) )
        die("file path not valid");
    if ( isset($argv[2]) && is_dir($argv[2]) )
        $dir	= $argv[2];
    else
        $dir	= "";
        
    $fp = fopen($argv[1], 'r'); // get file
    chdir($dir);
    preg_match('/^(.+)\/.+$/', $argv[1], $patterns);
    
    if (sizeof($patterns)>1)
    	chdir($patterns[1]);
    
    $depth  = 0;
    $line   = fgets($fp); // get first line
    $dir    = $line;
    while ( ($line) !== false ):
        $delta  = (strlen($line)-strlen(ltrim($line)))-$depth; // delta depth
        $depth  = (strlen($line)-strlen(ltrim($line))); // cur depth
        
        $up     = ($delta<0);
        if ( $up )
            for ( $i=0; $i<abs($delta); $i++ )
            	chdir('..');
        else if ( $delta>0 )
            chdir(trim($dir));
        
        $dir    = $line;
        $line   = trim($line);
        
        if ( !is_dir($line) && substr($line,0,1) !== '/' )
            mkdir($line);
            
        $line=fgets($fp); // next line
    endwhile;
?>