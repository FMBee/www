<?php
$GLOBALS['config'] = array(

		'mssql' => array(
				'mode'      => 'sqlsrv',
				'host'      => '10.106.76.111',
				'port'  	=> '1433',
				'username'  => 'sa',
				'password'  => 'Logiwin06',
				'db'        => 'winpneu'
		),
		'mysql' => array(
				'mode'      => '',
				'host'      => 'localhost',
				'port'  	=> '',
				'username'  => '',
				'password'  => '',
				'db'        => 'test'
		),
		'ftp' => array(
				'server'    => 'vps344570.ovh.net',
				'username'  => 'webmaster',
				'password'  => 'PeulvEf4'
		)
);
	require_once '../classes/config.php';
	require_once '../classes/db.php';
	require_once '../classes/dbmysql.php';

	if ( is_null($db = DBMysql::getInstance() ) ) {
	
		die(DBMysql::message());
	}
	
	$db->get(
			'spaces2'
	);
	
	if( $db->error() ){
		
		print_r( $db->message() );
	}
