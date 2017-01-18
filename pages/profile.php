<html>
<head>
<link rel='stylesheet' href='css/gallery.css'>
</head>
<body>

<?php

session_start();

if (isset($_SESSION['msg_flash']))
{
	foreach ($_SESSION['msg_flash'] as $type => $msg)
	{
		echo '<div id="msg-flash" class="msg-flash ';
		echo $type;
		echo '" onclick="document.getElementById(\'msg-flash\').style.display=\'none\';">';
		echo $msg;
		echo '</div>';
	}
	unset($_SESSION['msg_flash']);
}

?>

<div style="background-color:#292c2f; border-radius: 10px; color:floralwhite; margin: 80px 10% 0px 10%; padding: 20px 0 5px 0; text-align:center">
	<!-- formulaire d'upload -->
	<form action="actions/upload_picture.php" method="post" enctype="multipart/form-data">
		Upload :
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Upload Image" name="submit">
	</form>
</div>

<?php

echo "<div style='margin-top: 20px; width:80%; margin-left:10%'>";

if (isset($_SESSION['login'])) {

	require('config/database.php');

	$login = $_SESSION['login'];

	$bdd = new PDO($DB_DSN, $DB_USR, $DB_PWD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$req = $bdd->prepare('SELECT * FROM pictures WHERE user = :login');
	$req->bindParam(':login', $login, PDO::PARAM_STR, 255);
	$req->execute();

	$data = $req->fetchAll(PDO::FETCH_ASSOC);
	$bdd = null;

	if (!empty($data))
	{
		foreach ($data as $row)
		{
			$pic_name = substr($row['path'], 3);
			echo "<div class='responsive'>
				<div class='img'>
				<a target='' href='pages/test.php?picture=".$pic_name."'><img src='".$pic_name."' alt='' width='300' height='200'></a>
				<form method='post' action='actions/delete_photo.php' style='margin-bottom:0px;'>
				<input type='submit' value='delete' name='".$pic_name."'/ style='width:100%; margin-top:5px;'>
				</form>
				</div>
				</div>";
		}
		echo '<div class="clearfix"></div>';
	}
	else
	{
		echo "<div><center>Aucunes photos disponibles</center></div>";
	}
}
else {
	echo "<div><center>Aucun utilisateur connecte</center></div>";
}
echo "</div>";

?>
