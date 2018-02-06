<?php

	$root = 'www';
	$params = '{sep}search.yml';
	$sep = strtoupper(substr(PHP_OS, 0, 3)) == 'WIN' ? '\\' : '/' ;
	$dir = substr(__DIR__, 0, strrpos(__DIR__, $root));
	$path = $dir .$root .str_replace('{sep}', $sep, $params);
echo $path;
		
	$GLOBALS['__params__'] = yaml_parse_file($path);
print_r($GLOBALS);
exit;
	require_once 'POO_base/classes/config.php';
	require_once 'POO_base/classes/db.php';
	require_once 'POO_base/classes/dbmysql.php';

	$db = DBMysql::getInstance(); 

	
// 	$provagence = $db->query(
// 			'select * from new_fournisseurs2 join provider2 b on p_nom = b.nom left join agences2 c on a_nom = c.nom_agence'
// 			)
// 			->results();
	
// 	foreach ( $provagence as $ligne ) {
		
// 		array_walk($ligne, 'trim_value');
		
// 		$fields = array(
// 					'id_agence' =>      $ligne['id_agence'],          
// 					'id_fourn' =>       $ligne['id'],                 
// 					'tel' =>            $ligne['pa_tel'],             
// 					'fax' =>            $ligne['pa_fax'],             
// 					'contact1' =>       $ligne['pa_contact1'],        
// 					'mail' =>           $ligne['pa_mail'],            
// 					'identifiant' =>    $ligne['pa_login'],           
// 					'password' =>       $ligne['pa_passwd'],          
// 					'compte_liv' =>     $ligne['pa_compteliv'],       
// 					'compte_fac' =>     $ligne['pa_comptefac'],       
// 					'notes' =>          $ligne['pa_notes']            
// 		);
// 		$db->insert('prov_agence2', $fields);
// 		if( $db->error() )		print_r( $db->message() );
// 	}
	
// 	$provagence = $db->query(
// 			'select * from new_fournisseurs2 join provider2 b on p_nom = b.nom'
// 			)
// 			->results();

	
	echo 'fin - ', date('i:s');	
		
