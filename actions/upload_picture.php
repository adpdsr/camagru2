<?php

session_start();

if (isset($_SESSION['login']))
{
	$uploadOk = 1;
	$user = $_SESSION['login']; 
	$target_dir = "../img/users/" . $user . "/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

	// Check if image isnt fake
	if (isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		$type = mime_content_type($_FILES["fileToUpload"]["tmp_name"]);
		if ($check !== false || $type == 'image/png') {
			$_SESSION['msg_flash']['alert'] = "Sorry, wrong format";
			$uploadOk = 1;
		}
		else {
			$uploadOk = 0;
		}
	}
	else {
		$_SESSION['msg_flash']['alert'] = "Sorry, no file found";
	}

	/* Check users directory */
	if (!file_exists('../img/users')) {
		mkdir('../img/users');
	}

	/* Check users/user_name directory */
	if (!file_exists($target_dir)) {
		mkdir($target_dir);
	}

	/* Check picture_name */
	if (file_exists($target_file)) {
		$_SESSION['msg_flash']['alert'] = "Sorry, file already exists";
		$uploadOk = 0;
	}

	/* Check file size */
	if ($_FILES["fileToUpload"]["size"] > 10000000) {
		$_SESSION['msg_flash']['alert'] = "Sorry, your file is too large";
		$uploadOk = 0;
	}

	/* Check file format */
	if ($imageFileType != "png") {
		$_SESSION['msg_flash']['alert'] = "Sorry, only PNG files are allowed";
		$uploadOk = 0;
	}

	/* Check if upload status */
	if ($uploadOk == 0) {
		$_SESSION['msg_flash']['alert'] .= " : your file was not uploaded";
	}

	/* if everything is ok, try to upload file */
	else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			require_once('../config/database.php');
			$date = date("Y-m-d H:i:s");
			$_SESSION['msg_flash']['success'] = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded";
			$DB = new PDO($DB_DSN, $DB_USR, $DB_PWD);
			$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt = $DB->prepare('INSERT INTO pictures (user, likes, path, date) VALUES (:user, :likes, :path, :date)');
			$stmt->execute(array(':user' => $user, ':likes' => 0, ':path' => $target_file, ':date' => $date));

			$DB = null;
		}
		else {
			$_SESSION['msg_flash']['alert'] .= " : An error occured while uploading the file";
		}
	}

	header("Location: ../index.php?page=profile");

}
?>
