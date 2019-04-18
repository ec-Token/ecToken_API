<?php
function getData( string $url, array $arr , $type = "POST"){
	$postdata = json_encode($arr);
	$opts = array('http' =>
	    array(
	        'method'  => $type,
	        'header'  => 'Content-type: application/x-www-form-urlencoded',
	        'content' => $postdata
	    )
	);
	$context  = stream_context_create($opts);
	$result = file_get_contents($url, false, $context);
	return $result;
};
?>