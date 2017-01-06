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
				echo '<div class="middle">';
				echo 'Confirmation OK, votre compte a bien ete cree</br></br>';
				echo 'Cliquez <a href="index.php"><span>ici</span></a> pour vous connecter</br></br>';
				echo '</div>';
			}
			else
			{
				echo "<div class='middle'>email already confirmed</div>";
			}
		}
		else
		{
			echo "<div class='middle'>no user for this email</div>";
		}
		$DB = null;
	}
	catch(PDOException $e)
	{
		echo "query failed : " . $e->getMessage();
		die();
	}
}

?>
