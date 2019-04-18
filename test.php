<?php
include("libs/Base58.php");
echo getBase58CheckAddress(hex2bin("4132b5917c8541d5921bd9b5271de24cb596f3c2bb"));
$url = 'https://api.trongrid.io/wallet/getaccount';
var_dump(getData($url, array('address' => '4132b5917c8541d5921bd9b5271de24cb596f3c2bb')));


function getData( string $url, array $arr){
	$postdata = json_encode($arr);
	$opts = array('http' =>
	    array(
	        'method'  => 'POST',
	        'header'  => 'Content-type: application/x-www-form-urlencoded',
	        'content' => $postdata
	    )
	);
	$context  = stream_context_create($opts);
	$result = file_get_contents($url, false, $context);
	return $result;
};
?>