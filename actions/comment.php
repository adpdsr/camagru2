<?php

require_once("../config/database.php");
require_once("../includes/functions/send_mail.php");
require_once("../includes/functions/db_connexion.php");

session_start();

if (isset($_POST['comment']) && $_SESSION['login'])
{
	$com = $_POST['comment'];
	$usr = $_SESSION['login'];

	$key = array_keys($_POST);
	$pic = "../" . substr($key[1], 0, -4) . ".png";

	$dbc = dbConnexion($DB_DSN, $DB_USR, $DB_PWD);

	$sql = "SELECT id, user FROM pictures WHERE path='".$pic."'";
	$stm = $dbc->query($sql);
	$row = $stm->fetchObject();

	$pic_id = $row->id;
	$pic_usr = $row->user;

	$sql = "SELECT mail, login, notif FROM users WHERE login='".$pic_usr."'";
	$stm = $dbc->query($sql);
	$row = $stm->fetchObject();

	$usr_mail = $row->mail;
	$usr_login = $row->login;
	$time = date("Y-m-d H:i:s");

	$sql = "INSERT INTO comments(content, picture_id, user, date) VALUES ('".$com."', '".$pic_id."', '".$usr."', '".$time."')";
	$dbc->query($sql);

	if ($row->notif === '1') {
        send_mail($usr_mail, $pic_usr, "comment");
	}

	$dbc = null;
}

header('Location: ../index.php?page=gallery');

?>
