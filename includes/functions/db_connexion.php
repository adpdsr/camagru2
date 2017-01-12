<?php

function delete_directory($path) {

	if (is_dir($path) === true)
	{
		$files = array_diff(scandir($path), array('.', '..'));
		foreach ($files as $file)
		{
			delete_directory(realpath($path) . '/' . $file);
		}
		return rmdir($path);
	}
	else if (is_file($path) === true)
	{
		return unlink($path);
	}
	return false;
}

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
	return $dbc;
}

function dbQuery($dbc, $qry) {

	try
	{
		$dbc->exec($qry);
	}
	catch (PDOException $err)
	{
		$msg =  "database query KO : " . "error : " . $err->getMessage();
		echo "<script type='text/javascript'>alert('" . $msg . "');</script>";
		die();
	}
}

?>
