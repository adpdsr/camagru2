<?php
session_start();

require_once("includes/includes.php");

echo "<html>
	<head>
		<meta charset='UTF-8'>
		<title>camagru</title>
		<link rel='stylesheet' href='css/camagru.css'>
	</head>
	<body>
";

require_once("includes/templates/header.php");

if (!isset($_SESSION['login']) && empty($_GET['mail']))
{
	include("pages/login.php");
}
else if (isset($_GET['page']))
{
	get_page($_GET['page']);
}

require_once("includes/templates/footer.php");

echo "</body>
</html>
";

?>
