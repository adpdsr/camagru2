<?php

function dbConnexion($DB_DSN, $DB_USR, $DB_PWD) {

	try
	{
		$dbc = new PDO($DB_DSN, $DB_USR, $DB_PWD);
		$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $err)
	{
		$msg =  "database setup KO : " . "error : " . $err->getMessage();
		echo "<script type='text/javascript'>alert('" . $msg . "');</script>";
		die();
	}
	return ($dbc);
}

function dbQuery($DB_DSN, $DB_USR, $DB_PWD, $sql) {

	$dbc = dbConnexion($DB_DSN, $DB_USR, $DB_PWD);

	try
	{
		$dbc->exec($sql);
	}
	catch (PDOException $err)
	{
		$msg =  "database setup KO : " . "error : " . $err->getMessage();
		echo "<script type='text/javascript'>alert('" . $msg . "');</script>";
		die();
	}

	$dbc = NULL;
}

?>
