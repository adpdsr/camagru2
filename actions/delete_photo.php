<?php

require_once('../config/database.php');
require_once('../includes/functions/db_connexion.php');

/* get photo path */
$test = "../" . array_keys($_POST)[0];
$test = substr($test, 0, -4) . ".png";

/* delete photo db */
$dbc = dbConnexion($DB_DSN, $DB_USR, $DB_PWD);
$query = "DELETE FROM `pictures` WHERE `path`='" . $test . "'";
dbQuery($dbc, $query);
$dbc = null;

/* delete photo file */
if (file_exists($test))
	unlink($test);

header('Location: ../index.php?page=profile');

?>
