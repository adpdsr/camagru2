<div id="home-global">
	<div id="cam-container">
		<tr>
			<td>

<?php

if (isset($_SESSION['login'])) {

	require('config/database.php');

	$login = $_SESSION['login'];

	$DB = new PDO($DB_DSN, $DB_USR, $DB_PWD);
	$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = $DB->prepare('SELECT * FROM pictures');
	$sql->execute();

	$data = $sql->fetchAll(PDO::FETCH_ASSOC);
	$DB = null;

	if (!empty($data))
	{
		foreach ($data as $row) {
			$pic_name = substr($row['path'], 3);
			echo "<div style='display:inline-block'>";
			echo "	<img class='profile-pic' src=\"" . $pic_name . "\"/>";
			echo "	<from method='post' action='actions/likes.php'>";
			echo "		<input id='like-button' type='submit' name='" . $pic_name . "' value='like'>";
			echo "		<button class='" . $pic_name . "' onclick=\"document.getElementById('id01').style.display='block'\" style='width:auto;'>comment</button>";
			echo "	</form>";
			/*echo "
				<form method='post' class='modal-content' action='actions/comment.php'>
				<div class='form-container' style='background-color:#f1f1f1; text-align:center;'>
				<h2>Comment</h2>
				</div>
				<div class='form-container'>
				<textarea name='comment' id='comments' cols='34' rows='4' required></textarea>
				<button type='submit' name='toto'>send</button>
				</div>
				</form>
				";*/
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
</div>
