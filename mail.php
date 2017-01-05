<?php 

$str = $_SERVER['HTTP_HOST']."/cama/validation.php?p1=".$pseudo."&prenom=".$hmail;
$headers = 'From: webmaster@camagru.42.fr';
echo $str + "  -  " + $headers;
$ret = mail("cheuveux@gmail.com", 'Camagru email validation', $str, $headers);
var_dump($ret);
?>
