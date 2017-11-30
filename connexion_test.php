<?php 

$serveur = '10.110.76.246';
$user = 'speeddial';
$pass = 'speedpass';
$db = mysql_connect($serveur, $user, $pass); 
echo mysql_query("SET NAMES UTF8");
echo mysql_select_db('kiplink',$db); 
echo '<br />';

$sql = "select number from speeddial";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req)) 
{ 
  echo $data['number'].'<br />';
}
					

?>