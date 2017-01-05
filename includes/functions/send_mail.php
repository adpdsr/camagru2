<?php

function send_mail($mail, $login, $action) {

	if (!strcmp($action, "confirmation"))
	{
		$object = "Camagru : Confirmation";

		$header = "From: \"Camagru\"<camagru@42.fr>" . "\r\n";
		$header .= "Reply-to: \"Camagru\" <camagru@42.fr>". "\r\n";
		$header .= "Content-Type: text/html; charset=\"utf-8\"" . "\r\n";
		$header .= 'MIME-Version: 1.0' . "\r\n";

		$content = "<html>";
		$content .= "Bonjour <i>" . $login . "</i>, ";
		$content .= "<br/><br/>Cliquez ";
		$content .= "<a href='http://localhost:8080/camagru_v2/index.php?page=validation&mail=";
		$content .= base64_encode($mail) . "'>ici</a> pour valider votre compte !";
		$content .= "<br/><br/>A tres vite sur Camagru";
		$content .= "</html>";

		mail($mail, $object, $content, $header);
	}
}

?>
