<?php
/************************************************
 * MGW&A
 * title:	get_youtube
 * 
 * description:
 * gets a yt video given a url
 * 
 * parameters:
 * yt url
 */


function get_youtube($url, $w=560, $h=315) {
	preg_match('/(http\:\/\/)?(www\.)?youtube.com\/watch\?v\=([a-zA-Z0-9_\-]+)/', $url, $matches);
	if ( sizeof($matches) < 4 )
		preg_match('/(http\:\/\/)?(www\.)?youtu.be\/([a-zA-Z0-9_\-]+)/', $url, $matches);
	
	if ( !isset($matches[3]) )
		return;
	
	$contents	= '';
	ob_start();
?>
<iframe width="<?php echo $w; ?>" height="<?php echo $h; ?>" src="http://www.youtube.com/embed/<?php echo $matches[3]; ?>" frameborder="0" allowfullscreen></iframe>
<?php
	$contents	= ob_get_contents();
	ob_end_clean();
        
        return array(
            "embed"     =>$contents,
            "thumbnail" =>"http://img.youtube.com/vi/".$matches[3]."/0.jpg"
        );
}

?>