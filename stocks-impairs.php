<?php
    
	$DEV = ( isset($argv[1]) && $argv[1] == 'DEV' );
	
	require_once ('lib/PHPMailer/PHPMailer.php');
	require_once ('lib/PHPMailer/SMTP.php');    

    try {

//     	if ( ($code__eval = file_get_contents('/usr/share/php/common.yml')) === false )
//     		echo 'Common not found';
//     	else {
//     		eval($code__eval);
//     	}
        $serveur_sql = "10.106.76.111";
        $username = "sa";
        $password = "Logiwin06";
        
//         $base_wp = "winpneu_formation";
        $base_wp = "winpneu";

        // Linux
//         $conn = new PDO(
// 	        "dblib:host={$serveur_sql}:1433;dbname={$base_wp};charset=utf8",
// 	        $username,
// 	        $password
// 	        );
		// Windows
        $conn = new PDO(
        	"sqlsrv:Server={$serveur_sql},1433;Database={$base_wp}", 
        	$username, 
        	$password
        	);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    } catch (Exception $e) {
        die(print_r($e->getMessage));
    }
    
    $sql = "
    	select distinct c_agence, nom_agence, mail_exp, tel_1 from agence 
    	where c_agence not in ('SIAC','SICA','SIDI','SIGC','SIGM','SIL2','SILG','SIMA','SIPL','SISO','SITC','AGIP', 'XAVC','TEDE')
    	";
    
    $req = $conn->prepare($sql);
    $req->execute();
    $results_agence = $req->fetchAll(PDO::FETCH_ASSOC); // FETCH_ASSOC ou FETCH_BOTH
    
    $direction = '';
    
    foreach ($results_agence as $row_agence) {
        
        $c_agence = trim($row_agence['c_agence']);
        $article = '';
        
        $message = "
            <style>
            table {
              border-collapse: collapse;
            }
            
            table, td, th {
              padding: 6px;
              border: 1px solid black;
            }
            </style>
            ";
        $message .= "
        	<h2>Stocks impairs {$row_agence['nom_agence']} - "
        	.(new DateTime())->format('d/m/Y')
        	."</h2>";
        $message .= "
                <table style='border: 1px solid black; border-collapse: collapse'>
                <tr><th>Article</th><th>Libellé</th><th>Stock</th><th>PX achat</th><th>Autres dépôts</th><th>Qté</th></th>
                ";
        
        
        $sql_stock = "
                select s.c_depot, s.c_art, s.qte_en_stock, round(s.px_achat,2) as 'px_achat', 
                case when s1.c_depot is NULL then '' else s1.c_depot end as 'autre_depot', 
                case when s1.qte_en_stock is NULL then '' else s1.qte_en_stock end as 'qte_autre_depot',
                a.lib_art
                from stock s
                RIGHT JOIN stock s1
                 on s1.c_art = s.c_art and s1.c_depot <> s.c_depot and cast(s1.qte_en_stock as Numeric) % 2 = 1 and s1.c_depot not in ('AGIP')
                INNER JOIN article a
                	on a.c_art = s.c_art
                where s.qte_en_stock in ('1','3')
                and a.c_fam_art in ('01','02','03','04')
                and a.c_sfam_art not in ('AU','CC','CHE','CM','DA','DI','MC','MCP','MCR','MO','RB','RP','SC','VE')
                and s.c_depot = '$c_agence'
                order by 1,2
                ";
        // and a.c_art not in (select c_art from stock_art where qte_mini > 0 and c_depot = '$c_agence')
        // and s.c_depot in (select c_agence from agence where c_ste = 'GOUR')";
        
        $req = $conn->prepare($sql_stock);
        $req->execute();
        $results_stock = $req->fetchAll(PDO::FETCH_ASSOC); 
                                                           
        foreach ($results_stock as $row_stock) {
            
            $row_stock = array_map('trim', $row_stock);
            $autre_depot = $row_stock['autre_depot'];
            
            if ( !empty($autre_depot) ) {
                
                foreach ( $agences = $results_agence as $line ) {
                    
                    if ($line['c_agence'] == $autre_depot)     $tel = str_replace(' ', '.', trim($line['tel_1']));
                }
            }
            
            if ( $article == $row_stock['c_art'] ) {
                
                $message .= "
                    <tr>
                    <td colspan='4'></td>
                    <td style='background-color: lightgreen'>" . $autre_depot . ( isset($tel) ? " - " .$tel : "" ) . "</td>
                    <td style='text-align: center;background-color: lightgreen;'>" . intval(floatval($row_stock['qte_autre_depot'])) . "</td>
                    </tr>
                    ";
            }
            else {
                $message .= "
                    <tr><td style='background-color: lightblue' colspan='6'></td></tr>
                    ";
                $message .= "
                    <tr>
                    <td>" . $row_stock['c_art'] . "</td>
                    <td>" . $row_stock['lib_art'] . "</td>
                    <td style='text-align: center'>" . intval(floatval($row_stock['qte_en_stock'])) . "</td>
                    <td style='text-align: right'>" . sprintf('%01.2f', floatval($row_stock['px_achat'])) . " &euro;</td>
                    <td style='background-color: lightgreen'>" . $autre_depot . (isset($tel) ? " - " .$tel : "") . "</td>
                    <td style='text-align: center;background-color: lightgreen;'>" . intval(floatval($row_stock['qte_autre_depot'])) . "</td>
                    </tr>
                    ";
                
                $article = $row_stock['c_art'];
            }
            unset($tel);
        }
		        
        $message .= "</table><br><br>";
        $direction .= $message;
        
		if ( !$DEV ) {
	        // ///////////////////////////////////////////////////
	        // Mail Agence
	        // ////////////////////////////////////////////////////
	        $mail = new PHPmailer();
	        $mail->IsSMTP();
	        $mail->IsHTML(true);
	        $mail->Host = '10.106.76.135';
	        $mail->Port = 25;
	        $mail->SMTPAuth = false;
	        $mail->SMTPSecure = null;
	        $mail->From = 'ged@groupegarrigue.fr';
	        $mail->FromName = 'GIE Garrigue';
	        $mail->AddAddress($row_agence['mail_exp']);
	        $mail->Subject = "Stocks impairs {$row_agence['nom_agence']}";
	        $mail->Body = utf8_decode($message);
	        
	        if (! $mail->send()) { // Teste si le return code est ok.
	            echo $mail->ErrorInfo; // Affiche le message d'erreur (ATTENTION:voir section 7)
	        } else {
	            echo "Mail envoyé avec succès pour $c_agence".PHP_EOL;
	        }
	        $mail->smtpClose();
		}
        
    } // endfor

    echo $direction;
      
    // ///////////////////////////////////////////////////
    // Mail Direction
    // ////////////////////////////////////////////////////
    $objet = "Stocks impairs toutes agences";
    $mail = new PHPmailer();
    $mail->IsSMTP();
    $mail->IsHTML(true);
    $mail->Host = '10.106.76.135';
    $mail->Port = 25;
    $mail->SMTPAuth = false;
    $mail->SMTPSecure = null;
    $mail->From = 'ged@groupegarrigue.fr';
    $mail->FromName = 'GIE Garrigue';
    
    if ( $DEV ) {
    	
    	$mail->addAddress('fredericmevollon@universpneus.com');
    }
    else {
    	
	    $mail->AddAddress("laurentphilip@groupegarrigue.fr");
	    $mail->AddAddress("yvesgarrigue@groupegarrigue.fr");
	    $mail->AddAddress("erichameau@groupegarrigue.fr");
	    $mail->AddAddress("jeanleonpeigneguy@groupegarrigue.fr");
	    $mail->AddAddress("vantientran@groupegarrigue.fr");
	    $mail->AddAddress("philippeduclaux@groupegarrigue.fr");
	    $mail->AddAddress("olivierbasurko@groupegarrigue.fr");
	    $mail->AddAddress("juliebelet@groupegarrigue.fr");
	    $mail->AddAddress("mathieuclara@groupegarrigue.fr");
	    $mail->AddAddress("michelfaure@groupegarrigue.fr");
	    $mail->AddAddress("cyrilleferon@groupegarrigue.com");
	    $mail->AddAddress("francislaur@groupegarrigue.fr");
	    $mail->AddAddress("antoniomartins@groupegarrigue.fr");
	    $mail->AddAddress("jeanluccresson@groupegarrigue.fr");
	    $mail->AddAddress("mathieulequin@universpneus.fr");
		$mail->AddAddress("baptisteminet@groupegarrigue.com");
		$mail->AddAddress("christiancovinhes@orange.fr");
		$mail->AddAddress("fabienneaudoubert@groupegarrigue.com");
		$mail->AddAddress("gillesmerfeld@groupegarrigue.com");
		$mail->AddAddress("jeromegarrigue@groupegarrigue.com");
		$mail->AddAddress("laurentcadin@groupegarrigue.com");
		$mail->AddAddress("mathieufoures@groupegarrigue.com");
    	$mail->addBCC('fredericmevollon@universpneus.com');
    }
    
    $mail->Subject = $objet;
    $mail->Body = utf8_decode($direction);
    
    if (! $mail->Send()) { 
        echo $mail->ErrorInfo; 
    } else {
        echo "Mail envoyé avec succès pour direction".PHP_EOL;
    }
    
    $mail->SmtpClose();
    
?>
