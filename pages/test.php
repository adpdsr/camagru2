<div id='gallery-container' style='width: 80%; margin: 50px auto; padding-top: 50px; overflow: hidden;'>

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
		foreach ($data as $row)
		{
			$pic_name = substr($row['path'], 3);

			echo "<div class='gallery-item' style='color: #797478; width: 20%; margin: 0% 2% 50px 2%; float: left;'>";
			echo "<a href='#'><img src='" . $pic_name . "' alt='' style='max-width: 100%; border-radius: 5px;'></a>";

			echo "<form method='post' action='actions/likes.php'>";
			echo "	<input type='submit' name='" .$pic_name. "' value='like'/>";
			echo "</form>";

			echo "<form method='post' action='actions/comment.php'>";
			echo "	<textarea placeholder='type your comment here' style='width: 100%;' name='comment' required></textarea>";
			echo "	<input type='submit' name='" . $pic_name. "'/>";
			echo "</form></div>";
		}
		/*<button style='width: 100%; margin-top: 10px; margin-botton: 0px;'>comment</button>*/
	}
}
else
	echo "<div><center>no user</center></div>";
?>

</div>
