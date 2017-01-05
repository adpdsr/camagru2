<?php

require_once("../config/database.php");
require_once("../includes/functions/send_mail.php");

session_start();

if (empty($_POST['mail']) ||
	empty($_POST['login']) ||
	empty($_POST['password']))
	header("Location: ../index.php");
else
{
	$mail = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
	if (filter_var($mail, FILTER_VALIDATE_EMAIL) == false)
	{
		$_SESSION['msg_flash']['alert'] = "invalid email";
	}
	else if (!($login = filter_var($_POST['login'], FILTER_SANITIZE_STRING)))
	{
		$_SESSION['msg_flash']['alert'] = "invalid login";
	}
	else if (!($password = filter_var($_POST['password'], FILTER_SANITIZE_STRING)))
		$_SESSION['msg_flash']['alert'] = "invalid password";
	if (isset($_SESSION['msg-flash']))
		header("Location: login.php");
	$password = hash('whirlpool', $password);

	try
	{
		$DB = new PDO($DB_DSN, $DB_USR, $DB_PWD);
		$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $DB->prepare('INSERT INTO users (login, password, mail) VALUES (:login, :password, :mail)');
		$stmt->execute(array(':login' => $login, ':password' => $password, ':mail' => $mail));
		$DB = null;
	}

	catch(PDOException $e)
	{
		if ($e->getCode() == 23000)
		{
			$_SESSION['msg_flash']['alert'] = "Username or mail already exists !";
			header("Location: ../index.php");
		}
		else
			print "error : " . $e->getMessage() . "<br/>";
		die();
	}

	send_mail($mail, $login, "confirmation");
	
	$_SESSION['msg_flash']['success'] = "Votre compte a bien été créé !";
	header("Location: ../index.php");
}
?>
