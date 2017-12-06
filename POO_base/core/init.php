<?php

// session_start();

// error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
error_reporting(0);

$GLOBALS['config'] = array(
		
    'mssql' => array(
        'mode'      => 'sqlsrv',
        'host'      => '10.106.76.111',
        'port'  	=> '1433',
        'username'  => 'sa',
        'password'  => 'Logiwin06',
        'db'        => 'winpneu'
    ),
    'ftp' => array(
        'server'    => 'ftp.vulco.com',
        'username'  => 'ggptyre676',
        'password'  => 'Lmht1609!'
    )
);

spl_autoload_register( function($class) {
	
	$filename = 'classes/' .strtolower($class) .'.php';

	if (is_readable($filename)) {
		
		require_once $filename;
	}
});

require_once 'global.php';

