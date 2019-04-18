<?php
function hex2ByteArray($hexString) {
	$string = hex2bin($hexString);
    return $string;
}

function ldec2hex($str){
	$dec = $str;
	// init hex array
	$hex = array();
	 
	while ($dec) {
	    // get modulus // based on docs both params are string
	    $modulus = bcmod($dec, '16');
	    // convert to hex and prepend to array
	    array_unshift($hex, dechex($modulus));
	    // update decimal number
	    $dec = bcdiv(bcsub($dec, $modulus), 16);
	}
	 $rt = implode('', $hex);
	// array elements to string
	return $rt;
}


function bc2bin($num)
    {
        return dec2base($num, 256);
    }
function bin2bc($num)
    {
        return base2dec($num, 256);
    }

function bchexdec($hex)
{
    $dec = 0;
    $len = strlen($hex);
    for ($i = 1; $i <= $len; $i++) {
        $dec = bcadd($dec, bcmul(strval(hexdec($hex[$i - 1])), bcpow('16', strval($len - $i))));
    }
    return $dec;
}



function digits($base){
        if ($base > 64) {
            $digits = "";
            for ($loop = 0; $loop < 256; $loop++) {
                $digits .= chr($loop);
            }
        } else {
            $digits = "0123456789abcdefghijklmnopqrstuvwxyz";
            $digits .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ-_";
        }
        $digits = substr($digits, 0, $base);
        return (string)$digits;
    }
?>