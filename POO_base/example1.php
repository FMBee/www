<?php

	require_once 'core/init.php';

	$logs = new Log('ftp_articles.log');
	$logs->init();

	//------------------ connexion FTP
	
	if ( is_null($ftp = FTP::getInstance()) ) {
		
		$logs->put(FTP::message() .' - aborting');
		die('exit');
	}
	$logs->put('FTP connecté');

	
	//------------------- connexion base
	
	if ( is_null($db = DBMssql::getInstance() ) ) {
		
		$logs->put(DBMssql::message() .' - aborting');
		die('exit');
	}
	$logs->put('Base connectée');
	
	include 'requete_1.php';
	
	if ( !$db->error() ){
		
		$logs->put(print_r($db->first(), true));
		$logs->put((string)$db->count() .' records found');
	}
	else{
		$logs->put($db->message()  .' - aborting');
		die('exit');
	}
// 	file_put_contents('articles.prn', print_r($db->results(), true));

	
	//------------------- export Excel
	
	$file = 'export_articles_' .date('Y-m-d_H-i') .'.xlsx';
	
	if ( !($xls = new classeurPHPExcel($file)) ) {
		
		$logs->put("Output file {$file} exists - aborting");
		die('exit');
	}
	
	$lig = 1;
	
	foreach ( $fields as $id => $field ) {
		
		$xls->headline($lig, $id, $field);
	}
	$lig++;
	
	foreach ( $db->results() as $result ) {
		
		$col = 0;
		
		foreach ( $result as $value ) {
		
			$xls->tabline($lig, $col++, empty($value) ? '' : trim($value));
		}
		$lig++;
	}
	$xls->close();
	$logs->put("File generated : {$file}");
		

	//------------------- envoi FTP
	
	if ( $ftp->put($file, $file) ) {
		
		$logs->put('Transfert n°' .(string)$ftp->putCount() ." - {$file} effectué");
	}
	else{
		$logs->put($ftp->message());
	}

	$ftp->close();
	
	$logs->close();

	
// echo date('H:i'), ' terminé.';	
// debug($GLOBALS);

?>
