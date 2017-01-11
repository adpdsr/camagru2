<?php

session_start();

require_once("database.php");
//require_once("../includes/functions/db_connexion.php");

try
{
	// $lhc = dbConnexion("mysql:host=localhost", $DB_USR, $DB_PWD);
	$bdd = new PDO("mysql:host=localhost", $DB_USR, $DB_PWD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$bdd->exec('DROP DATABASE IF EXISTS camagru');
	$bdd->exec('CREATE DATABASE camagru');
	$DB = new PDO($DB_DSN, $DB_USR, $DB_PWD);

	if (file_exists("../img/users/"))
		rmdir("../img/users");

	mkdir("../img/users/");

	$DB->exec("CREATE TABLE `users` (
		`id` INT PRIMARY KEY AUTO_INCREMENT,
		`login` VARCHAR(255) UNIQUE NOT NULL,
		`mail` VARCHAR(255) UNIQUE NOT NULL,
		`confirmed` BOOLEAN NOT NULL DEFAULT FALSE,
		`reseted` BOOLEAN NOT NULL DEFAULT FALSE,
		`password` VARCHAR(255) NOT NULL)");

	$DB->exec("CREATE TABLE `pictures` (
		`id` INT PRIMARY KEY AUTO_INCREMENT,
		`user` VARCHAR(255) NOT NULL,
		`path` VARCHAR(255) NOT NULL,
		`likes` INT NOT NULL DEFAULT 0)");

	$DB->exec("CREATE TABLE `comments` (
		`id` INT PRIMARY KEY AUTO_INCREMENT,
		`content` TEXT NOT NULL,
		`picture_id` INT NOT NULL,
		`user_id` varchar(255) NOT NULL,
		`date` datetime NOT NULL)");

	$DB = null;
}

catch (PDOException $e)
{
	$message = "database setup KO : " . "error : " . $e->getMessage();
	echo "<script type='text/javascript'>alert('" . $message . "');</script>";
	die();
}

$_SESSION['login'] = NULL;

header('url=../index.php?page=login');

?>
