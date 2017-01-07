<?php

session_start();

if (isset($_SESSION['login']))
{
    $user = $_SESSION['login'];
    
    $target_dir = "../img/users/" . $user . "/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    
    // Check if image is no fake
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
			//echo " | File is an image | ";
            $uploadOk = 1;
        }
        else {
            //echo " | File is not an image | ";
            $uploadOk = 0;
        }
    }

    // Check users directory
	if (!file_exists('../img/users')) {
        mkdir('../img/users');
	}

    // Check users/user_name directory
	if (!file_exists($target_dir)) {
		mkdir($target_dir);
	}

    // Check picture_name
	if (file_exists($target_file)) {
		$_SESSION['msg_flash']['alert'] = "Sorry, file already exists";
        $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 10000000) {
		$_SESSION['msg_flash']['alert'] = "Sorry, your file is too large";
        $uploadOk = 0;
    }
    
    // Check file format
    if ($imageFileType != "png") {
		$_SESSION['msg_flash']['alert'] = "Sorry, only PNG files are allowed";
        $uploadOk = 0;
    }
    
    // Check if upload status
    if ($uploadOk == 0) {
		$_SESSION['msg_flash']['alert'] .= " : your file was not uploaded";
    }
    
    // if everything is ok, try to upload file
    else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			//$_SESSION['msg_flash']['success'] = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded";
            require_once('../config/database.php');
            $DB = new PDO($DB_DSN, $DB_USR, $DB_PWD);
            $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $DB->prepare('INSERT INTO pictures (user, likes, path) VALUES (:user, :likes, :path)');
            $stmt->execute(array(':user' => $user, ':likes' => 0, ':path' => $target_file));

            $DB = null;
        }
        else {
			$_SESSION['msg_flash']['alert'] .= " : An error occured while uploading the file";
        }
    }
    
    header("Location: ../index.php?page=profile");
    
}
?>
