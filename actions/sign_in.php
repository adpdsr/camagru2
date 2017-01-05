<?php

require_once "../config/database.php";

session_start();

if (( $_POST['login'] == "" || $_POST['password'] == ""))
{
	/* if javascript disable */
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
		$stmt = $DB->prepare('SELECT * FROM users WHERE login = :login AND password = :password');
		$stmt->execute(array(
			':login' => $login,
			':password' => $password
		));
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$DB = null;
		if (!empty($data))
		{
			$_SESSION['login'] = $login;
			header("Location: ../index.php?page=home");
		}
		else
		{
			$_SESSION['msg_flash']['alert'] = "Incorrect login or password";
			header("Location: ../index.php");
		}
	}
	catch(Exception $e)
	{
		$_SESSION['msg_flash']['alert'] = "Connexion failed";
		header("Location: ../index.php");
	}
}

?>
