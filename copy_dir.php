<?php
/************************************************
 * MGW&A
 * title:	goto dir
 * 
 * description:
 * performs recursive copy
 * 
 * parameters:
 * source folder and destination address for copied folder
 */

function	copy_dir($src, $dest) {
	if( is_dir($src) )
	{
		@mkdir( $dest );
		$objects = scandir($src);
		if( sizeof($objects) > 0 )
		{
			foreach( $objects as $file )
			{
				if( $file == "." || $file == ".." )
					continue;
				// go on
				if( is_dir( $src."/".$file ) )
					copy_dir( $src."/".$file, $dest."/".$file );
				else
					copy( $src."/".$file, $dest."/".$file );
			}
		}
		return true;
	}
	elseif( is_file($src) )
		return copy($src, $dest);
	else
		return false;
}

?>