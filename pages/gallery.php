<html>
<head>
<link rel='stylesheet' href='css/gallery.css'>
</head>
<body>

<?php

session_start();

echo "<div style='margin-top: 100px; width:80%; margin-left:10%'>";

if (isset($_SESSION['login'])) {

	require('config/database.php');

	$login = $_SESSION['login'];
	$DB = new PDO($DB_DSN, $DB_USR, $DB_PWD);
	$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = $DB->prepare('SELECT * FROM pictures ORDER BY date DESC');
	$sql->execute();
	$data = $sql->fetchAll(PDO::FETCH_ASSOC);
	$DB = null;

	if (!empty($data)) {

		foreach ($data as $row) {

			$pic_name = substr($row['path'], 3);
			echo "<div class='responsive'>
				<div class='img'>
				<a target='' href='pages/test.php?picture=".$pic_name."'><img src='".$pic_name."' alt='' width='300' height='200'></a>
				<form method='post' action='actions/likes.php' style='margin-bottom:5px;'>
				<input type='submit' name='".$pic_name."' value='like' style='width:100%; margin-top:5px;'/>
				</form>
				<form method='post' action='actions/comment.php' style='margin-bottom:0px;'>
				<textarea placeholder='type your comment here' style='width: 100%;' name='comment' required></textarea>
				<input type='submit' name='".$pic_name."'/ style='width:100%; margin-top:5px;'>
				</form>
				</div>
				</div>";
		}
	}
	else {
		echo "<div><center>no picture</center></div>";
	}
}
else {
	echo "<div><center>no user</center></div>";
}

?>

<div class="clearfix"></div>
</div>
</body>
</html>
