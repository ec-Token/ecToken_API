<?php
function SHA256(string $data, $raw = true): string{
        return hash('sha256', $data, $raw);
}

function sha256d(string $data): string{
        return hash('sha256', hash('sha256', $data, true), true);
}

function RIPEMD160(string $data, $raw = true): string{
        return hash('ripemd160', $data, $raw);
}
?>