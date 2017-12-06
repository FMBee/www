<?php

$serveur = '51.255.39.154';

// Soumettre le ping (0 = machine joignable)  
exec("ping -n 2 {$serveur}", $output, $return);	//cde Windows ! -c sous Linux

/** SI la machine n'est pas joignable **/
if ( $return != 0 ) {
	
    echo date('H:i')," {$serveur} injoignable ";
    notificationMail(array($serveur, $output, $return));
}
else {
    echo date('H:i')," {$serveur} joignable ";
//    notificationMail(array($serveur, $output, $return));
}
print_r($output);


function notificationMail($data) {

	$html = '
	<html>
	<body>
		<br />
		Problème détecté sur le serveur ' .$data[0] .'<br />
		<br />
		Messages retournés par le système :<br />
		<br />
		Code: ' .(string)$data[2] .'<br /><br />'
		.implode('<br />', $data[1]) .'
	</body>
	</html>
	';

	return sendMail ( 	'f.mevollon@gmail.com',
						'Problème serveur - ' .date('d/m/Y H:i'),
						$html
			);
}

function sendMail($adresse, $objet, $message) {

	require_once ('lib/PHPMailer/PHPMailer.php');
	require_once ('lib/PHPMailer/SMTP.php');

	// PHPMailer Object
	$mail = new PHPMailer ();

	// Enable SMTP debugging.
	// $mail->SMTPDebug = 3;
	// Set PHPMailer to use SMTP.
	$mail->isSMTP ();
	// Set SMTP host name
	$mail->Host = "smtp.sfr.fr";
	// Set this to true if SMTP host requires authentication to send email
	$mail->SMTPAuth = true;
	// Provide username and password
	$mail->Username = "f.mevollon@sfr.fr";
	$mail->Password = "cadoul46";
	// If SMTP requires TLS encryption then set it
	$mail->SMTPSecure = "ssl";
	// Set TCP port to connect to
	$mail->Port = 465;

	// From email address and name
	$mail->From = "f.mevollon@nautilusweb.fr";
	$mail->FromName = "Fred";
	// Address to which recipient will reply
	$mail->addReplyTo ( "f.mevollon@gmail.com", utf8_decode( "Frédéric" ) );
	// CC and BCC
	// $mail->addCC("cc@example.com");
	// $mail->addBCC("bcc@example.com");
	// Send HTML or Plain Text email
	$mail->isHTML ( true );

	// To address and name
	$mail->addAddress ( $adresse );

	$mail->Subject = utf8_decode($objet);
	
	$mail->Body = utf8_decode($message);
	
	// $mail->AltBody = "This is the plain text version of the email content";

	$mail->SmtpClose ();

	if (! $mail->send ()) {

		return $mail->ErrorInfo;
	} else {
		return true;
	}
}

?>