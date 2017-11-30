<?php
echo 'mssql_ / ', date('H:i').'<br />';

$serveur_sql="10.106.76.111";
$username="sa";
$password="Logiwin06";
$base_wp = "winpneu";

echo $sqlconnect = mssql_connect($serveur_sql, $username, $password);
echo mssql_select_db($base_wp,$sqlconnect);
echo '<br />';

//On liste toutes les familles clients et on batti la liste déroulante
$sql_fourn = "select c_fourn,nom_fourn from fourn where c_blocage_fourn = 'N' order by 1";
$req_fourn = mssql_query($sql_fourn); 
while($data_fourn = mssql_fetch_array($req_fourn)) 
{ 
  $c_fourn = trim($data_fourn['c_fourn']);
  $nom_fourn = trim($data_fourn['nom_fourn']);
  echo $c_fourn." - ".$nom_fourn.'<br />';
}

?>