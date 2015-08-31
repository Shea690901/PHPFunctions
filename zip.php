<?php

include_once(__DIR__.'/sfile_get_contents.php');
function zip($basedir, $filelist, $dest) {
	$obj	= new ZipArchive();
	if ( $obj->open($dest, ZipArchive::CREATE) === true ) {
		foreach ( $filelist as $file ) {
			$directories	= explode('/', substr($file,strlen($basedir)));
			array_pop($directories);
			$obj->addEmptyDir(substr(implode($directories, '/'),1));
			$obj->addFile($file, substr($file,strlen($basedir)+1));
		}
		$obj->close();
		$contents	= sfile_get_contents($dest);
		return $contents;
	}

	return "";
}

?>