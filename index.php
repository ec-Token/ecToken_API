<?php
include("libs/Parse.php");
include("libs/Base58.php");
$host = "https://api.trongrid.io";
$assetID = "1002235"; // mainnet "1002235": testnet "1000250"
if (isset($_GET['getAccount'])){
	$address = $_POST['address'];
	$obj = json_decode(getData($host."/wallet/getaccount", array('address' => $address)));
	$dec = json_decode(getData($host."/wallet/getaccountnet", array('address' => $address)));
	$freeNetLimit = $dec->freeNetLimit;
	$freeNetUsed = 0;
	if(isset($dec->freeNetUsed)){
		$freeNetUsed = $dec->freeNetUsed;
	}
foreach ($obj->assetV2 as &$value) {
	if ($value->key == $assetID) {
		$Account = array('addressHex' => $address, 'address' => getBase58CheckAddress(hex2bin($address)) ,'amount' => $value->value, "freeNetUsed" => $freeNetUsed, "freeNetLimit" => $freeNetLimit, "totalNetUsed" => $freeNetLimit - $freeNetUsed);
		echo json_encode($Account);
	} else {

	}
    
}
//echo $obj->address;
} elseif (isset($_GET['Address2Hex'])) {
	$address = $_GET['address'];
	$str = ldec2hex(decode($address));

	$str = substr($str, 0, -(4 * 2));
	echo json_encode(array('addressHex' => $str));

} elseif (isset($_GET['Hex2Address'])) {
	$address = $_GET['address'];
	echo json_encode(array('address' => getBase58CheckAddress(hex2bin($address))));
	
} elseif(isset($_GET['genAddress'])){
	echo getData($host."/wallet/generateaddress", array());

} elseif(isset($_GET['transferbyprivate'])){
	$private_key = $_POST['privateKey'];
	$toAddress = $_POST['toAddress'];
	$amount = $_POST['amount'];
	echo getData($host."/wallet/easytransferassetbyprivate", array("privateKey" => $private_key, "toAddress" => $toAddress, "assetId" => $assetID ,"amount" => intval($amount)));
} elseif(isset($_GET['getNetUsed'])){
	$address = $_POST['address'];
	$dec = json_decode(getData($host."/wallet/getaccountnet", array("address" => $address)));
	
	$freeNetLimit = $dec->freeNetLimit;
	$freeNetUsed = 0;
	if(isset($dec->freeNetUsed)){
		$freeNetUsed = $dec->freeNetUsed;
	}
	echo json_encode(array("freeNetUsed" => $freeNetUsed, "freeNetLimit" => $freeNetLimit, "totalNetUsed" => $freeNetLimit - $freeNetUsed));
} elseif(isset($_GET['getTransactions'])){
		$address = getBase58CheckAddress(hex2bin($_POST['address']));
		$start = $_POST['start'];
		$limit = $_POST['limit'];
		
		echo getData("https://api.trxplorer.io/v2/account/".$address."/transfers?start=".$start."&limit=". $limit ."&token=1002235", array(), "GET");
} elseif(isset($_GET['getTransactionsCount'])){
	    $address = getBase58CheckAddress(hex2bin($_POST['address']));
	    $obj = json_decode(getData("https://api.trxplorer.io/v2/account/".$address."/transfers?token=1002235", array(), "GET"));
		echo json_encode(array("count" => $obj->total));
} else {
	echo "API Error!";
}



?>
