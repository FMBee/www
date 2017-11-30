<?php
echo 'pdo_sqlsrv_ / ', date('H:i').'<br />';

try {

$serveur_sql="10.106.76.111";
$username="sa";
$password="Logiwin06";
$base_wp = "winpneu";

$conn = new PDO("sqlsrv:Server={$serveur_sql},1433;Database={$base_wp}", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
	die(print_r($e->getMessage));
}

$sql_fourn = "select c_fourn,nom_fourn from fourn where c_blocage_fourn = 'N' order by 1";
$req_fourn = $conn->prepare($sql_fourn); 
$req_fourn->execute();
$results = $req_fourn->fetchall(PDO::FETCH_BOTH);


foreach ($results as $data_fourn) {

  $c_fourn = trim($data_fourn['c_fourn']);
  $nom_fourn = trim($data_fourn['nom_fourn']);
  echo $c_fourn." - ".$nom_fourn.'<br />';
}

?>