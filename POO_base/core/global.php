<?php

function simplePre($data){
	
    echo '<pre>';
    echo $data;
    echo '</pre>';
}

function pre($value){
	
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}

function varPre($value){
	
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

function debug($var, $console=false) {
	
	if ($console) {
		
		print_r($var);
	}
	else {
		echo "\n<!-- ";
		print_r($var);
		echo " -->\n";
	}
}

/*
 * usage: array_walk($array, 'trim_value');
 */
function trim_value(&$value) {

	$value = trim ( $value );
}