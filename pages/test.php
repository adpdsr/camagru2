<?php

session_start();

echo "<html>
	<head>
	<meta charset='UTF-8'>
	<title>camagru</title>
	<link rel='stylesheet' href='../css/camagru.css'>
	</head>
	<body>";

echo "<div class='fixed-header'>
	<div class='container'>
	<h1><a href='#'>Cama<span>gru</span></a></h1>";

if (isset($_SESSION['login'])) {
	echo "<nav>
		<a href='../actions/logout.php' style='color:#A0140D;'>Logout</a>
		<a href='../index.php?page=profile'>Profile</a>
		<a href='../index.php?page=gallery'>Gallery</a>
		<a href='../index.php?page=home'>Home</a>
		</nav>";
}

echo "</div>
	</div>";

echo "<center><div style='height:auto; padding-top:20px; padding-bottom: 50px;'>";

if (isset($_SESSION['login']))
{
	require('../config/database.php');
	require('../includes/functions/db_connexion.php');

	if (isset($_GET['picture']) || isset($_SESSION['login']))
	{
		$user = $_SESSION['login'];
		$picture = $_GET['picture'];
		$picture_path = "../" . $picture;

		echo "<img src='".$picture_path."' style='width:30%;'>";

		$dbc = dbConnexion($DB_DSN, $DB_USR, $DB_PWD);

		$sql = $dbc->prepare("SELECT id, user FROM pictures WHERE path='".$picture_path."'");
		$sql->execute();

		$data = $sql->fetchAll(PDO::FETCH_ASSOC);
		if (!empty($data[0]['id']))
		{
			$picture_id = $data[0]['id'];
			$picture_user = $data[0]['user'];
			$sql = $dbc->prepare("SELECT * FROM comments WHERE picture_id='".$picture_id."'");
			$sql->execute();

			$data = $sql->fetchAll(PDO::FETCH_ASSOC);
			echo "<div style='width:30%; margin-top:20px; margin-bottom:20px; text-align:left'>";
			echo "<h3>Photo de ".$picture_user."</h3>";
			foreach ($data as $row)
			{
				$com_usr = $row['user'];
				$com_date = $row['date'];
				echo "<p>".$com_usr . " le " . $com_date." : ".$row['content']."</p>";
			}
			echo "</div>";
		}

		$dbc = null;
	}
}

echo "</div></center>";

require_once("../includes/templates/footer.php");

echo "</body>
	</html>";

?>
