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

session_start();

if (isset($_GET['mail']))
{
	$mail = base64_decode($_GET['mail']);

	require("config/database.php");
	require("includes/functions/db_connexion.php");

	$dbc = dbConnexion($DB_DSN, $DB_USR, $DB_PWD);
	$sql = $dbc->prepare("SELECT * FROM `users` WHERE `mail`='".$mail."'");
	$sql->execute();
	$data = $sql->fetchAll(PDO::FETCH_ASSOC);

	if (isset($data))
	{
		if (intval($data['reseted']) == 0)
		{
			$count = $dbc->exec("UPDATE `users` SET `reseted`='0' WHERE `mail`='".$mail."'");
			if ($count == 1)
			{
				$sql = $dbc->prepare("SELECT * FROM `users` WHERE `mail`='".$mail."'");
				$sql->execute();
				$data = $sql->fetchAll(PDO::FETCH_ASSOC);
				if (isset($data))
				{
					$newpwd = $data[0]['newpwd'];
					$count = $dbc->exec("UPDATE `users` SET `password`='".$newpwd."', `newpwd`='' WHERE `mail`='".$mail."'");
					if ($count == 1)
					{
						echo '<div class="mail-page1">
							<div class="mail-page2">
							Nouveau mot de passe OK</br></br>
							Cliquez <a href="index.php"><span>ici</span></a> pour vous connecter</br>
							</div>
							</div>
							';
					}
					else
					{
						echo '<div class="middle">An error occured, please try again</div>';
					}
				}
				else
				{
					echo '<div class="middle">An error occured, please try again</div>';
				}
			}
			else
			{
				echo '<div class="middle">An error occured, please try again</div>';
			}
		}
		else
		{
			echo '<div class="middle">An error occured, please try again</div>';
		}
	}
	else
	{
		echo '<div class="middle">An error occured, please try again</div>';
	}
}
else
{
	echo '<div class="middle">An error occured, please try again</div>';
}

$dbc = null;

?>

</body>
</html>
