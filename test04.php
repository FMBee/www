<?php

print_r($argv);

$path= "c:\\xampp\\mysql\\bin\\";
$cmd = "mysqldump --user=root --password=eclipse pricing > " .'pricing_db_' .date('Y-m-d_H-i') .'.sql';

exec($path.$cmd, $out, $return);

print_r($return);
print_r($out);