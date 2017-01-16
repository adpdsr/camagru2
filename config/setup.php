<?php

session_start();

require_once("database.php");
require_once("../includes/functions/db_connexion.php");

/* database creation */
$lhc = dbConnexion("mysql:host=localhost", $DB_USR, $DB_PWD);
$lhc->exec('DROP DATABASE IF EXISTS camagru');
$lhc->exec('CREATE DATABASE camagru');
$lhc = null;

/* reset img/users directory */
delete_directory("../img/users/");
mkdir("../img/users/");

/* database setup */
$dbc = dbConnexion($DB_DSN, $DB_USR, $DB_PWD);

dbQuery($dbc, "CREATE TABLE `users` (
	`id` INT PRIMARY KEY AUTO_INCREMENT,
	`login` VARCHAR(255) UNIQUE NOT NULL,
	`mail` VARCHAR(255) UNIQUE NOT NULL,
	`confirmed` BOOLEAN NOT NULL DEFAULT FALSE,
	`reseted` BOOLEAN NOT NULL DEFAULT FALSE,
	`password` VARCHAR(255) NOT NULL)");

dbQuery($dbc, "CREATE TABLE `pictures` (
	`id` INT PRIMARY KEY AUTO_INCREMENT,
	`user` VARCHAR(255) NOT NULL,
	`path` VARCHAR(255) NOT NULL,
	`likes` INT NOT NULL DEFAULT 0,
	`date` datetime NOT NULL)");

dbQuery($dbc, "CREATE TABLE `comments` (
	`id` INT PRIMARY KEY AUTO_INCREMENT,
	`content` TEXT NOT NULL,
	`picture_id` INT NOT NULL,
	`user` varchar(255) NOT NULL,
	`date` datetime NOT NULL)");

dbQuery($dbc, "CREATE TABLE `likes` (
		`id` INT NOT NULL,
		`login` VARCHAR(255) NOT NULL)");

$dbc = null;

$_SESSION['mail'] = null;
$_SESSION['login'] = null;

header('Location: ../index.php?page=login');

?>
