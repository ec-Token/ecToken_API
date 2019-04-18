<?php
include("Hash.php");
include("Crypto.php");
//echo getBase58CheckAddress(hex2bin("4132b5917c8541d5921bd9b5271de24cb596f3c2bb"));

$alphabet = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';


    function getBase58CheckAddress(string $addressBin): string{
        $hash0 = SHA256($addressBin);
        $hash1 = SHA256($hash0);
        $checksum = substr($hash1, 0, 4);
        $checksum = $addressBin . $checksum;
        return encode(bin2bc($checksum));
    }

    function base2dec($value, $base, $digits = false){
        if (extension_loaded('bcmath')) {
            if ($base < 2 || $base > 256) {
                die("Invalid Base: " . $base);
            }
            bcscale(0);
            if ($base < 37) {
                $value = strtolower($value);
            }
            if (!$digits) {
                $digits = digits($base);
            }
            $size = strlen($value);
            $dec = "0";
            for ($loop = 0; $loop < $size; $loop++) {
                $element = strpos($digits, $value[$loop]);
                $power = bcpow($base, $size - $loop - 1);
                $dec = bcadd($dec, bcmul($element, $power));
            }
            return (string)$dec;
        } else {
            die('Please install BCMATH');
        }
    }

    function dec2base($dec, $base, $digits = false)
    {
        if (extension_loaded('bcmath')) {
            if ($base < 2 || $base > 256) {
                die("Invalid Base: " . $base);
            }
            bcscale(0);
            $value = "";
            if (!$digits) {
                $digits = digits($base);
            }
            while ($dec > $base - 1) {
                $rest = bcmod($dec, $base);
                $dec = bcdiv($dec, $base);
                $value = $digits[$rest] . $value;
            }
            $value = $digits[intval($dec)] . $value;
            return (string)$value;
        } else {
            die('Please install BCMATH');
        }
    }

    function decode(string $addr, int $length = 58): string
    {
        return base2dec($addr, $length, "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz");
    }

    function encode($num, $length = 58): string
    {
        return dec2base($num, $length, "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz");
    }

    function encoding(string $string, int $prefix = 128, bool $compressed = true)
    {
        $string = hex2bin($string);
        if ($prefix) {
            $string = chr($prefix) . $string;
        }
        if ($compressed) {
            $string .= chr(0x01);
        }
        $string = $string . substr(SHA256(SHA256($string)), 0, 4);
        $base58 = encode(bin2bc($string));
        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] != "\x00") {
                break;
            }
            $base58 = '1' . $base58;
        }
        return $base58;
    }


    

function decoding(string $string, int $removeLeadingBytes = 1, int $removeTrailingBytes = 4, bool $removeCompression = true)
    {
        $string = bin2hex(bc2bin(decode($string)));
        //If end bytes: Network type
        if ($removeLeadingBytes) {
            $string = substr($string, $removeLeadingBytes * 2);
        }
        //If the final bytes: Checksum
        if ($removeTrailingBytes) {
            $string = substr($string, 0, -($removeTrailingBytes * 2));
        }
        //If end bytes: compressed byte
        if ($removeCompression) {
            $string = substr($string, 0, -2);
        }
        return $string;
    }



    
?>