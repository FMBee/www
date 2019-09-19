<?php
echo 'pdo_sqlsrv_ / ', date('H:i').'<br /><br />';

try {

$serveur_sql="10.106.76.111";
$username="sa";
$password="Logiwin06";
// $base_wp = "winpneu_formation";
$base_wp = "winpneu";

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
// $sql = "select c_fourn, c_agence, c_cpte from fourn_cpte";
// $sql = "select * from article where c_art_fourn = '58420'";// and gencode = '3188642315786' ";
// $sql = "
//             select sum(qte_vendue) as qte from stat_gen s
//                         inner join article a on s.c_art = a.c_art
//                         where date_fac between dateadd(mm, -12, getdate()) AND getdate()
//                         and a.c_marque in ('FIRE','GOCH','SAVA','UNIR')
//                         and a.c_sfam_art = 'TE'
//                         and a.largeur = '185'
//                         and a.serie = '60'
//                         and a.diam = '15'
//                         and a.ind_vit like '%H%'
//                         and a.ind_charge like '%84%'
//                         and a.runflat = 'N' and a.renforce = 'N'                       
// ";
// $sql = "select * from ent_fac where n_fac = '210000146' order by n_fac desc";

// $sql = "
// select * from stat_gen s
// inner join article a on s.c_art = a.c_art
// where date_fac between dateadd(mm, -12, getdate()) AND getdate()
// and a.c_marque in ('MICH')
// and a.c_sfam_art = 'CE'
// and a.largeur = '175'
// and a.serie = '65'
// and a.diam = '14' and ( a.ind_vit like '%L%' or a.ind_vit like '%M%' or a.ind_vit like '%N%' or a.ind_vit like '%P%' 
// or a.ind_vit like '%Q%' or a.ind_vit like '%R%' or a.ind_vit like '%S%' or a.ind_vit like '%T%' ) and a.ind_charge like '%90/88%' 
// and a.runflat = 'N' and a.renforce = 'N'
// ";
$sql = "
select top 1 * from article
";
$sql = "
select  c_art, c_fam_art,c_sfam_art,c_marque,lib_art,ind_charge,Ind_charge_jumelee,Ind_complementaire from article
where Ind_charge_jumelee != ''
";
$sql="
SELECT s.c_art as article, c.c_tarif1 as grille, avg( s.mt_ca / s.qte_vendue ) as tarifht, avg( s.mt_revient / s.qte_vendue ) as achatht FROM stat_gen s	
JOIN client c on s.c_agence = c.c_agence and c.c_compte = 'N' 
WHERE 	s.c_art = ?
and (s.date_fac between ? and ?)
and c.c_tarif1 in (?)
group by s.c_art, c.c_tarif1
order by s.c_art, c.c_tarif1
";
$params=Array
(
    '2256016HWSP3DAO',
    '20170301',
    '20180228',
    "'VUL1','VUL2','VUL3'"
    );
$sql = "
update client set c_tarif1 = (
    case c_tarif1 
        when 'XXX' then 'VUL1' 
        when 'YYY' then 'VUL2' 
        when 'ZZZ' then 'VUL3' 
        else c_tarif1 
    end )
";



$sql = "
select  n_immatricul, count(*) as nb from contrat_veh   group by n_immatricul having count(*) > 1
";
$sql = "
select  n_immatricul, count(*) as nb from veh_client   group by n_immatricul having count(*) > 1
";
$sql = "
select c_client, type_contrat, count(n_immatricul) as nbCG from contrat_veh where type_contrat = 'K' group by c_client, type_contrat
";
$sql = "
select count(*) from article
where ind_charge like '%/%' and c_arret_gamme = 'N'
 and c_fam_art = '01'
";  //22-03:1761 - 26-03:234
$sql0 = "
select count(*) from article
where Ind_charge_jumelee != '' and c_arret_gamme = 'N'
 and c_fam_art = '01'
 and c_sfam_art in ('TE','TH','TTS','CE','CH','CTS','44','4H','4TS')
";  //22-03:1761 - 26-03:234

$params=array();

try {
    $req = $conn->prepare($sql0); 
    $req->execute($params);

}catch(PDOException $e){
    
    die($req->errorInfo()[2] ." / Erreur de requete : {$sql0}");
}

// $results = $req->fetch()[0];
$results = $req->fetchAll(PDO::FETCH_ASSOC);  //FETCH_ASSOC ou FETCH_BOTH

print_r($results);


/*
$sql = "select count(*) from articles"
                            FETCH_ASSOC         FETCH_BOTH      
echo $results[0][''];       INT                 INT
echo $results[0][0];        ERROR               INT

$sql = "select count(*) from articles"
                            FETCH_ASSOC         FETCH_BOTH      
echo $results[0][''];       ERROR               ERROR
echo $results[0][0];        ERROR               VALUE
*/




?>