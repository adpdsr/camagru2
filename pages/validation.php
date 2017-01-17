<html>
<head>
<style type='text/css'>

.mail-page1 {
	padding: 10px;
	width: 100%;
	height: 70%;
}

.mail-page2 {
	text-align: center;
	padding: 30px;
	margin : 100px auto;
	width: 30%;
	min-width: 320px;
	background-color: #292c2f;
	border-radius: 25px;
	color: floralwhite;
}

</style>
</head>
<body>

<?php

require("config/database.php");

session_start();

if (isset($_GET["mail"]))
{
	$mail = base64_decode($_GET["mail"]);

	try {
		$DB = new PDO($DB_DSN, $DB_USR, $DB_PWD);
		$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$req = $DB->prepare('SELECT * FROM users WHERE mail = :mail');
		$req->bindParam(':mail', $mail, PDO::PARAM_STR, 255);
		$req->execute();

		$data = $req->fetchAll(PDO::FETCH_ASSOC);
		if (!empty($data))
		{
			if (intval($data['confirmed']) == 0)
			{
				$_SESSION['msg_flash']['success'] = "Ready to connect !";
				$DB->exec('UPDATE `users` SET `confirmed` = "1" WHERE mail = "' . $mail . '"');
				echo '<div class="mail-page1">
					<div class="mail-page2">
					Confirmation OK, votre compte a bien ete cree</br></br>
					Cliquez <a href="index.php"><span>ici</span></a> pour vous connecter</br>
					</div>
					</div>
					';
			}
			else
			{
				echo "<div class='mail-page'>email already confirmed</div>";
			}
		}
		else
		{
			echo "<div class='mail-page'>no user for this email</div>";
		}
		$DB = null;
	}
	catch(PDOException $e)
	{
		echo "query failed : " . $e->getMessage();
		die();
	}
}
else
{
	echo '<div class="mail-page">An error occured, please try again</div>';
}

?>

</body>
</html>
