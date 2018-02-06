<?php
$GLOBALS['config'] = array(

		'mysql' => array(
				'mode'      => '',
				'host'      => 'localhost',
				'port'  	=> '',
				'username'  => 'root',
				'password'  => 'eclipse',
				'db'        => 'providers'
		),
);
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
	
	$provagence = $db->query(
			'select * from new_fournisseurs2 join provider2 b on p_nom = b.nom'
			)
			->results();

	$data=array();
	
// 	foreach ( $provagence as $ligne ) {
		
// 		array_walk($ligne, 'trim_value');
		
// 		if ( $ligne['p_tta'] == 'X') {
			
// 			$sql = "select a.id_agence as idda from agences2 a left join (select * from prov_agence2 
// 					where id_fourn = ?) b on a.id_agence = b.id_agence where isnull(b.id)";
			
// 			$agences = $db->query($sql, array($ligne['id']))->results();
 			
// // 			$data[$ligne['id']] = $agences;
// 			foreach ( $agences as $agence ) {
				
// 				$db->insert('prov_agence2', array( 
// 						'id_agence' => $agence['idda'],
// 						'id_fourn' => $ligne['id'],
// 						'flag' => 'M'
// 				));
// 				if( $db->error() )		print_r( $db->message() );
// 			}
// 		}
// 	}
// // 	print_r($data);

	
	echo 'fin - ', date('i:s');	
		
//--------------		
function trim_value(&$value) {

	$value = trim ( $value );
}