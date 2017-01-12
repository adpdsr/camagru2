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

<div id="home-global">
			<!-- formulaire d'upload -->
			<form action="actions/upload_picture.php" method="post" enctype="multipart/form-data">
				Upload :
				<input type="file" name="fileToUpload" id="fileToUpload">
				<input type="submit" value="Upload Image" name="submit">
			</form>
			<!-- photos de l'utilisateur -->
			<div id="cam-container">
				<tr>
					<td>
<?php

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
			echo "<div style='display:inline-block'>";
			echo "	<img onclick='' class='profile-pic' src=\"" . $pic_name . "\"/>";
			echo "	<form method='post' action='actions/delete_photo.php'>";
			echo "		<input id='del_button' type='submit' name='" . $pic_name . "' value='delete'>";
			echo "	</form>";
			echo "</div>";
		}
	}
}
else
	echo "<div><center>no user</center></div>";
?>
					</td>
				</tr>
			</div>

			<div id="pic-container">
			</div>
		</div>
