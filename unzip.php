<?php
/************************************************
 * MGW&A
 * title:	unzip
 * 
 * description:
 * unzip the contents of a compressed .zip file to target dir
 * 
 * parameters:
 * file
 * target directory to unzip
 */


/* http://php.net/manual/en/ref.zip.php */

include_once(__DIR__.'/goto_dir.php');
function unzip($file, $targetdir){
    $zip = zip_open($file);
	if ( substr($targetdir,-1) != '/' && substr($targetdir,-1) != "\\" )
			$targetdir	.= '\\';
	
	if ( !goto_dir($targetdir) )
		return;
	
    if(is_resource($zip)){
        $tree = "";
        while(($zip_entry = zip_read($zip)) !== false){
			chdir($targetdir);
            echo "Unpacking ".zip_entry_name($zip_entry)."\n";
            if(($last = strrpos(zip_entry_name($zip_entry), '\\')) !== false ||
			   ($last = strrpos(zip_entry_name($zip_entry), '/')) !== false ){
                $dir = substr(zip_entry_name($zip_entry), 0, $last);
                $file = substr(zip_entry_name($zip_entry), $last+1);
				
                if(!is_dir($dir)){
                    @mkdir($dir, 0755, true) or die("Unable to create $dir\n");
                }

                if(strlen(trim($file)) > 0){
					chdir($targetdir.$dir);
                    $return = @file_put_contents($file, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
                    if($return === false){
                        die("Unable to write file $dir/$file\n");
                    }
                }
            }else{
                file_put_contents(zip_entry_name($zip_entry), zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
            }
        }
    }else{
        echo "Unable to open zip file\n";
    }
}

?>