<?php

session_start();

require_once("includes/includes.php");

echo "
<html>
	<head>
		<meta charset='UTF-8'>
		<title>camagru</title>
		<link rel='stylesheet' href='css/camagru.css'>
		<script src='./js/webcam.js'></script>
	</head>
	<body>
";

require_once("includes/templates/header.php");

if (!isset($_SESSION['login']) && empty($_GET['mail']))
{
//	echo "t1";
	include("pages/login.php");
}
else if (isset($_GET['page']))
{
//	echo "t2";
	get_page($_GET['page']);
}

require_once("includes/templates/footer.php");

echo "
	</body>
</html>
";

?>
