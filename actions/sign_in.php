<?php

require_once "../config/database.php";

session_start();

if (($_POST['login'] == "" || $_POST['password'] == ""))
{
	header("Location: ../index.php");
}
else
{
	$login = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
	$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
	$password = hash('whirlpool', $password);
	try
	{
		$DB = new PDO($DB_DSN, $DB_USR, $DB_PWD);
		$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = $DB->prepare('SELECT * FROM users WHERE login = :login AND password = :password');
		$query->execute(array(':login' => $login, ':password' => $password));
		$data = $query->fetchAll(PDO::FETCH_ASSOC);
		$data = $data[0];
		$DB = null;
		if (!empty($data))
		{
			if (intval($data['confirmed']) == 1)
			{
				$_SESSION['login'] = $login;
				header("Location: ../index.php?page=home");
			}
			else
			{
				$_SESSION['msg_flash']['alert'] = "Veuillez confirmer votre email";
				header("Location: ../index.php");
			}
		}
		else
		{
			$_SESSION['msg_flash']['alert'] = "Mauvais login ou mot de passe";
			header("Location: ../index.php");
		}
	}
	catch(Exception $e)
	{
		$_SESSION['msg_flash']['alert'] = "Echec de la connexion à la base de donnée";
		header("Location: ../index.php");
	}
}

?>
