<?php
echo 'sqlsrv_ / ', date('H:i').'<br />';


$serveur_sql="10.106.76.111";
$username="sa";
$password="Logiwin06";
$base_wp = "winpneu";

$conn = sqlsrv_connect($serveur_sql, array("Database"=>$base_wp, "UID"=>$username, "PWD"=>$password));

if ($conn) {
	echo "Success !".'<br />';
}
else{
	die("Error !");
}

$sql_fourn = "select c_fourn,nom_fourn from fourn where c_blocage_fourn = 'N' order by 1";
$req_fourn = sqlsrv_query($conn, $sql_fourn); 

while ($data_fourn = sqlsrv_fetch_array($req_fourn, SQLSRV_FETCH_ASSOC)) {

  $c_fourn = trim($data_fourn['c_fourn']);
  $nom_fourn = trim($data_fourn['nom_fourn']);
  echo $c_fourn." - ".$nom_fourn.'<br />';
}

?>