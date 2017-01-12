<?php

require_once("../config/database.php");
require_once("../includes/functions/db_connexion.php");

session_start();


if (isset($_POST['comment']) && $_SESSION['login'])
{
	$com = $_POST['comment'];
	$usr = $_SESSION['login'];

	$dbc = dbConnexion($DB_DSN, $DB_USR, $DB_PWD);

	print_r($_POST);
}
else
{
	echo "commentary KO";
	// add msg flash
}

?>
