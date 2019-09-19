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
				'password'  => 'eclipse',
				'db'        => 'commandeDimension'
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
	
	$db->query("
SELECT DISTINCT trim(t0.sfamArt) AS sfamArt, trim(t0.largeur) AS largeur, trim(t0.serie) AS serie, trim(t0.diametre) AS diametre, 
trim(t0.indVitesse) AS indVitesse, trim(t0.indCharge) AS indCharge, trim(t0.rof) AS rof, trim(t0.xl) AS xl
FROM dimension t0
    ");

	$dimensions = $db->results();
	$search = "
SELECT d.*, cd.id as cdId, categorie_id FROM dimension d left join categorie_dimension cd on d.id = cd.dimension_id
 WHERE sfamArt=? and largeur=? and serie=? and diametre=? and indVitesse=? and indCharge=? and rof=? and xl=?
 group by d.id
 order by sfamArt,largeur,serie,diametre,indVitesse,indCharge,rof,xl, d.id
    ";

	$delDim = array();
	$modDim = array();
	
	foreach ( $dimensions as $dimension ) {

	    $db->query($search, array(
	        $dimension['sfamArt'],
	        $dimension['largeur'],
	        $dimension['serie'],
	        $dimension['diametre'],
	        $dimension['indVitesse'],
	        $dimension['indCharge'],
	        $dimension['rof'],
	        $dimension['xl']
	        )
	    );
// 	    if( !$db->error() ){
	        
// 	        print_r( $db->results() );
// 	    }
//     	print_r(DBMysql::message());
// 	    exit();
	    $lignes = $db->results();
	    
	    $nbl = count($lignes);
	    
	    if ( $nbl > 1 ) {
	        
	        if ( !is_null($lignes[0]['categorie_id']) ) {
	        
	            if ( !is_null($lignes[1]['categorie_id']) ) {
	            
	               $modDim[] = array($lignes[0]['id'], $lignes[1]['id']);
    	        }else{
	               $delDim[] = $lignes[1]['id'];
    	        }
	        }
	        elseif ( !is_null($lignes[0]['concatIndVit']) and !is_null($lignes[0]['concatIndVit'])  ) {
	            
    	        if ( !is_null($lignes[1]['categorie_id']) ) {
	               $delDim[] = $lignes[0]['id'];
    	        }else{
	               $delDim[] = $lignes[1]['id'];
    	        }
	        }
	        elseif ( !is_null($lignes[1]['concatIndVit']) and !is_null($lignes[1]['concatIndVit'])  ) {
	            
	            $delDim[] = $lignes[0]['id'];
	        }
	        else{
	            $delDim[] = $lignes[1]['id'];
	        }
	    }
	}
	foreach ( $delDim as $id ) {
	    
	    $db->query(
            "INSERT into deldim SELECT * from dimension where id=?",
	        array($id)
        );
	    $db->query(
            "DELETE from dimension where id=?",
	        array($id)
        );
	    $db->query(
            "DELETE from categorie_dimension where dimension_id=?",
	        array($id)
        );
	}
	foreach ( $modDim as $ids ) {
	    
	    $db->query(
            "INSERT into deldim SELECT * from dimension where id=?",
	        array($ids[1])
        );
	    $db->query(
            "DELETE from dimension where id=?",
	        array($ids[1])
        );
	    $db->query(
            "UPDATE categorie_dimension set dimension_id=? where dimension_id=?",
	        array($ids[0], $ids[1])
        );
	}
	
	echo count($delDim), ' deleted';
	
		
