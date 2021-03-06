<?php

require_once('../includes/functions/send_mail.php');

session_start();

if (isset($_POST['login']) && isset($_POST['mail']) && isset($_POST['newpwd']))
{
	require_once('../includes/functions/db_connexion.php');
	require_once('../config/database.php');

	$mail = $_POST['mail'];
	$login = $_POST['login'];
	$newpwd = $_POST['newpwd'];
	if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,16}$/', $newpwd) === 1)
	{
		send_mail($mail, $login, 'reset');

		$dbc = dbConnexion($DB_DSN, $DB_USR, $DB_PWD);
		$count = $dbc->exec("UPDATE `users` SET `reseted`='1' WHERE `login`='".$login."'");
		if ($count == 1)
		{
			$count = $dbc->exec("UPDATE `users` SET `newpwd`='".hash('whirlpool', $newpwd)."' WHERE `login`='".$login."'");
			if ($count == 1)
			{
				$_SESSION['msg_flash']['success'] = "Un email vous a été envoyé, veuillez confirmer la demande de réinitialisation";
			}
			else
			{
				$_SESSION['msg_flash']['alert'] = "Une erreur est survenue, veuillez réessayer";
			}
		}
		else
		{
			$_SESSION['msg_flash']['alert'] = "Login incorrect";
		}
		$dbc = null;
	}
	else
	{
		$_SESSION['msg_flash']['alert'] = "Le mot de passe doit contenir entre 8 et 16 caractères, au moins un nombre, une majuscule et une minuscule";
	}
}
else
{
	$_SESSION['msg_flash']['alert'] = "Informations manquantes, veuillez réessayer";
}

header('Location: ../index.php');

?>
