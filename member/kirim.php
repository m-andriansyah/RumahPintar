<?php
// echo file_get_contents("http://192.168.137.207");

$hasil= file_get_contents("http://127.0.0.1/ip.txt");
// $hasil=192.168.137.180;
// $file = fopen("http://supernet.subnet.gq/faktur.txt","r");    
// $R=fread($file,filesize("http://supernet.subnet.gq/faktur.txt"));    
// fclose($file);
$cmd = $_GET['cmd'];
$fp =file_get_contents("http://$hasil/?$cmd");
// echo "R= ".$hasil;
 // echo "fp= ".$fp;
 
 ?>