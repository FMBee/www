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
				'username'  => 'root',
				'password'  => '',
				'db'        => 'test'
		),
		'ftp' => array(
				'server'    => 'vps344570.ovh.net',
				'username'  => 'webmaster',
				'password'  => 'PeulvEf4'
		)
);
	require_once 'POO_base/classes/config.php';
	require_once 'POO_base/classes/db.php';
	require_once 'POO_base/classes/dbmysql.php';

	$db = DBMysql::getInstance(); 
	
	$db->get(
			'spaces'
	);
	
	$db->get(
			'spaces',
			array(
					'id', 
					'nom'
			)
	);
	
	$db->get(
			'spaces',
			array(
					'id', 
					'nom'
			),
			'parent = 1'
	);
	
	$db->get(
			'spaces',
			array(
					'id', 
					'nom'
			),
			'parent = ?',
			array(
					'2'
			)
	);
	if( !$db->error() ){
		
		print_r( $db->results() );
	}
