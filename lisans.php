<?php
function encrypt($data){
    $out='';
    for($i=0;$i<strlen($data);$i++){
        $out .= chr((ord($data[$i]) + 10) % 256);
    }
    return $out;
}

$ip        = $_GET['ip']        ?? '';
$timestamp = $_GET['timestamp'] ?? '';
$clientHash= urldecode($_GET['hash'] ?? '');

if (abs(time() - (int)$timestamp) > 30) exit("EXPIRED");

$secretKey    = "edithsupersecret2025";
$expectedHash = encrypt($ip.$timestamp.$secretKey);

$allowedIps = ["188.119.2.119","185.160.30.10","auto"];

// basit log
file_put_contents(__DIR__.'/lisans_log.txt',
    date("Y-m-d H:i:s")." IP:$ip TS:$timestamp OK:".($clientHash===$expectedHash)."\n",
    FILE_APPEND);

if ($clientHash === $expectedHash && in_array($ip,$allowedIps)) {
    exit("LehomakaminaS");
}
exit("FAIL");
