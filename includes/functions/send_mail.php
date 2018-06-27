<?php

function send_mail($mail, $login, $action) {

    // ini_set('sendmail_from', "camagru@42.fr");

	if (!strcmp($action, "confirmation"))
	{
		$object = "Camagru : Confirmation";

		$header = "From: \"Camagru\"<camagru@42.fr>" . "\r\n";
		$header .= "Reply-to: \"Camagru\" <camagru@42.fr>". "\r\n";
		$header .= "Content-Type: text/html; charset=\"utf-8\"" . "\r\n";
		$header .= 'MIME-Version: 1.0' . "\r\n";
		$header .= 'X-Mailer: PHP/' . phpversion();

		$content = "<html>";
		$content .= "Bonjour <i>" . $login . "</i>, ";
		$content .= "<br/><br/>Cliquez ";
		$content .= "<a href='http://localhost:8080/camagru/index.php?page=validation&mail=";
		$content .= base64_encode($mail) . "'>ici</a> pour valider votre compte !";
		$content .= "<br/><br/>A tres vite sur Camagru";
		$content .= "</html>";

		return mail($mail, $object, $content, $header);
	}
	else if (!strcmp($action, "reset"))
	{

		$object = "Camagru : Reset";

		$header = "From: \"Camagru\"<camagru@42.fr>" . "\r\n";
		$header .= "Reply-to: \"Camagru\" <camagru@42.fr>". "\r\n";
		$header .= "Content-Type: text/html; charset=\"utf-8\"" . "\r\n";
		$header .= 'MIME-Version: 1.0' . "\r\n";

		$content = "<html>";
		$content .= "Bonjour <i>" . $login . "</i>, ";
		$content .= "<br/><br/>Cliquez ";
		$content .= "<a href='http://localhost:8080/camagru/index.php?page=reset&mail=";
		$content .= base64_encode($mail) . "'>ici</a> pour reinitialiser votre mot de passe !";
		$content .= "<br/><br/>A tres vite sur Camagru";
		$content .= "</html>";

		return mail($mail, $object, $content, $header);
	}
	else if (!strcmp($action, "comment"))
	{
		$object = "Camagru : Nouveau commentaire";

		$header = "From: \"Camagru\"<camagru@42.fr>" . "\r\n";
		$header .= "Reply-to: \"Camagru\" <camagru@42.fr>". "\r\n";
		$header .= "Content-Type: text/html; charset=\"utf-8\"" . "\r\n";
		$header .= 'MIME-Version: 1.0' . "\r\n";

		$content = "<html>";
		$content .= "Bonjour <i>" . $login . "</i>, ";
		$content .= "<br/><br/>Une de vos photo viens d'etre commentee !";
		$content .= "<br/><br/>A tres vite sur Camagru";
		$content .= "</html>";

		return mail($mail, $object, $content, $header);
	}
}

?>
