<?php
echo 'pdo_sqlsrv_ / ', date('H:i').'<br />';

try {

$serveur_sql="10.106.76.111";
$username="sa";
$password="Logiwin06";
$base_wp = "winpneu_formation";

$conn = new PDO("sqlsrv:Server={$serveur_sql},1433;Database={$base_wp}", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
	die(print_r($e->getMessage));
}

// $sql = "select nom_fourn from fourn where c_blocage = 'N' order by 1";
// $sql = "select count(*) from lig_tarif where c_tarif in ('VUL1', 'VUL2', 'VUL3')";
// $sql = "select top 10 * from lig_tarif where c_tarif in ('VUL1', 'VUL2', 'VUL3')";
// $sql = "select * from fourn where nom_fourn like '%astrak%'";
// $sql = "select * from fourn where c_blocage_fourn <> 'N'";
// $sql = "select c_fourn, nom_fourn, no_cpt, n_cpte_fourn from fourn where c_blocage_fourn in ('N', '')";
$sql = "select c_fourn, c_agence, c_cpte from fourn_cpte";


$req = $conn->prepare($sql); 
$req->execute();
$results = $req->fetchAll(PDO::FETCH_ASSOC);

print_r($results);

if ( false ) {
	
	$fp = fopen(__DIR__.'_cpte.csv', 'w+');
	fputcsv($fp, ['c_fourn', 'c_agence', 'fourn_cpte'], ';');
	
	foreach ($results as $result)
		fputcsv($fp, $result, ';');
	
	fclose($fp);	
}

// foreach ($results as $data) {

//   $c = trim($data['c']);
//   $nom = trim($data['nom']);
//   echo $c." - ".$nom.'<br />';
// }

?>