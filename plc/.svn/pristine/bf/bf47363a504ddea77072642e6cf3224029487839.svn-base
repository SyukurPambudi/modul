<?php 

$sharename = '\\\\10.1.48.21\Sys3';
$username = 'Mansur';
$password = 'N14615';
$letter = 'Zx:';    

if (!is_dir($letter . "/tmp")) {
    $WshNetwork = new COM("WScript.Network");
    $WshNetwork->MapNetworkDrive($letter, $sharename, FALSE, $username, $password);
}


?>