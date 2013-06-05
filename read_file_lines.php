<?php

	function	read_file_lines($file) {
		$file_contents	= file_get_contents($file);
		preg_match_all('/.+/', $file_contents, $matches, false);
		return $matches;
	}

?>