<div id='gallery-container' style='width: 80%; margin: 50px auto; padding-top: 50px; overflow: hidden;'>

<?php

session_start();

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
		foreach ($data as $row)
		{
			$pic_name = substr($row['path'], 3);

			echo "<div style='background-color: #292c2f; padding: 10px; color: #797478; width: 20%; margin: 0% 2% 2% 0%; float: left;'>";
			echo "<a href='#'><img src='" . $pic_name . "' alt='' style='max-width: 100%; border-radius: 5px;'></a>";

			echo "<form method='post' action='actions/likes.php' style='margin-bottom:5px;'>";
			echo "	<input type='submit' name='" .$pic_name. "' value='like' style='width:100%; margin-top:5px;'/>";
			echo "</form>";

			echo "<form method='post' action='actions/comment.php' style='margin-bottom:0px;'>";
			echo "	<textarea placeholder='type your comment here' style='width: 100%;' name='comment' required></textarea>";
			echo "	<input type='submit' name='" . $pic_name. "'/ style='width:100%; margin-top:5px;'>";
			echo "</form>";
			echo "</div>";
		}
	}
}
else
	echo "<div><center>no user</center></div>";
?>

</div>
