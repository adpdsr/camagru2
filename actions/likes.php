<?php

require_once("../config/database.php");
require_once("../includes/functions/db_connexion.php");

session_start();

if (isset($_POST) && isset($_SESSION['login']))
{
	$user = $_SESSION['login'];
	$keys = array_keys($_POST);
	$pict = "../" . substr($keys[0], 0, -4) . ".png";
	if (isset($pict) && isset($user))
	{
		$dbc = dbConnexion($DB_DSN, $DB_USR, $DB_PWD);
		
		echo $pict . "</br>";
		echo "../img/users/arthur/1484240055.png";
	}
}
?>
