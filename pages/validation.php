
<?php

echo '<div class="middle">';
echo 'Confirmation OK, votre compte a bien ete cree';

if (isset($_GET["mail"]))
{
	$mail = base64_decode($_GET["mail"]);
	echo "email = ";
	echo $mail;

	/* connect to db */
	/* check if mail exist */
	/* check if confirmed field is fale */
	/* update confrimed field to true */

	/*
	$email = secure($email, 1);
	Database::Query('SELECT * FROM accounts WHERE email = "'.$email.'"');
	if (Database::Get_Rows(NULL))
	{
		Database::Fetch_Assoc(NULL);
		if (intval(Database::$assoc["active"]) == 0)
		{
			Database::Query('UPDATE accounts SET active = "1" WHERE email = "'.$email.'"');
			print_message("Votre compte a été valider, vous pouvez désormais vous connecter !", "success");
		}
		else
			print_message("Votre compte a déjà été activé !", "error");
	}
	else
		print_message("Cet email n'existe pas :(", "error");
}
else
	print_message("Une erreur est survenue.", "error");
	 */

}

echo '</div>';

?>
