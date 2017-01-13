<?php

require_once("config/database.php");

session_start();

if (isset($_GET["mail"]))
{
	$mail = base64_encode($_GET["mail"]);

	try
	{
		// connect to db
		// select reseted du user
		// si reseted == 1
		//		affichage du formulaire de reinitialisation
		//		dans la page appelee par le form, reset le champ reseted a 0
		// sinon afficher erreur et rediriger vers login
	}
}
else
{
	//$msg = "Echec de reinitialisation de mot de passe, veuillez reessayer svp");
	//displayError($msg);
}

?>
