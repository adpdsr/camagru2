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
			echo "<img onclick='' class='profile-pic' src=\"" . substr($row['path'], 3) . "\"/>";
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
