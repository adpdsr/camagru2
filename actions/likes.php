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

		$sql = $dbc->prepare("SELECT * FROM pictures WHERE path='" . $pict . "'");
		$sql->execute();

		$data = $sql->fetchAll(PDO::FETCH_ASSOC);
		$pict_id = $data[0]['id'];

		$sql = $dbc->prepare("SELECT id FROM likes WHERE id='" . $pict_id . "' AND login='" . $user . "'");
		$sql->execute();
		$data = $sql->fetchAll(PDO::FETCH_ASSOC);

		if (empty($data))
		{
			/* insert into like table */
			$sql = $dbc->prepare("INSERT INTO likes(id, login) VALUES ('".$pict_id."', '".$user."')");
			$sql->execute();

			/* insert into picture table */
			$sql = $dbc->prepare("UPDATE pictures SET likes= likes + 1 WHERE path = '" . $pict . "'");
			$sql->execute();
		}
		$dbc = null;
	}
}

header("Location: ../index.php?page=gallery");
