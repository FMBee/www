<?php


$out = fopen('tmpclean.csv', 'w');

if ( ($in = fopen('tmpfile.csv', 'r')) !== false ) {
    
    while ( ($data = fgets($in, 2048)) !== false ) {
        
        if ( strlen(trim(str_replace(';', '', $data))) > 0 ) {
            
            fputs($out, $data);
        }
    }
    fclose($in);
    fclose($out);
    copy('tmpclean.csv', 'tmpfile.csv');
    unlink('tmpclean.csv');
}
else{
    die('exit');
}