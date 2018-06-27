<html>
	<head>
		<meta charset='UTF-8'>
		<title>camagru</title>
		<link rel='stylesheet' href='http://localhost:8080/camagru/css/camagru.css'>
	</head>
	<body>

<?php

session_start();

require_once("includes/includes.php");
require_once("includes/templates/header.php");

if (!isset($_SESSION['login']) && empty($_GET['mail']) && $_GET['page'] !== 'gallery') {
	include("pages/login.php");
} else if (isset($_GET['page'])) {
	get_page($_GET['page']);
} else if (isset($_SESSION['login'])) {
	include("pages/home.php");
} else {
    include("page/login.php");
}

require_once("includes/templates/footer.php");

?>

	</body>
</html>
