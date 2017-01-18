<table id="page-table">

<?php

session_start();

if (isset($_SESSION['msg_flash']))
{
	foreach ($_SESSION['msg_flash'] as $type => $msg)
	{
		echo '<div id="msg-flash" class="msg-flash ';
		echo $type;
		echo '" onclick="document.getElementById(\'msg-flash\').style.display=\'none\';">';
		echo $msg;
		echo '</div>';
	}
	unset($_SESSION['msg_flash']);
}
?>

			<tr>
				<td id="page-td">
					<div id="global">
						<h1>Cama<span>gru</span></h1>
						<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Sign in</button>
						<button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Sign up</button>
						<button onclick="document.getElementById('id03').style.display='block'" style="width:auto;">Reset</button>
					</div>

					<!-- Formulaire de connexion au compte -->
					<div id="id01" class="modal">
						<form method="post" class="modal-content" action="actions/sign_in.php">
							<div class="form-container" style="background-color:#f1f1f1; text-align:center;">
								<h2>sign in</h2>
							</div>
							<div class="form-container">
								<label><b>Username</b></label>
								<input type="text" placeholder="Enter Username" name="login" maxlength="16" required>
								<label><b>Password</b></label>
								<input type="password" placeholder="Enter Password" name="password" maxlength="16" required>
								<button type="submit">Sign in</button>
							</div>
							<div class="form-container" style="background-color:#f1f1f1">
								<button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn" style='width:100%'>Cancel</button>
							</div>
						</form>
					</div>

					<!-- Formulaire de création de compte -->
					<div id="id02" class="modal">
						<form method="post" class="modal-content" action="actions/sign_up.php">
							<div class="form-container" style="background-color:#f1f1f1; text-align:center;">
								<h2>sign up</h2>
							</div>
							<div class="form-container">
								<label><b>Username</b></label>
								<input type="text" placeholder="Enter Username" name="login" maxlength="16" required>
								<label><b>Password</b></label>
								<input type="password" placeholder="Enter Password" name="password" maxlength="16" required>
								<label><b>Email</b></label>
								<input type="text" placeholder="Enter Email" name="mail" required>
								<button type="submit">Sign up</button>
							</div>
							<div class="form-container" style="background-color:#f1f1f1">
								<button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn" style="width:100%">Cancel</button>
							</div>
						</form>
					</div>

					<!-- Formulaire d'envoi de mail pour le reset du pwd -->
					<div id="id03" class="modal">
						<form method="post" class="modal-content" action="actions/reset.php">
							<div class="form-container" style="background-color:#f1f1f1; text-align:center;">
								<h2>reset password</h2>
							</div>
							<div class="form-container">
								<label><b>Username</b></label>
								<input type="text" placeholder="Enter Username" name="login" maxlength="16" required>
								<label><b>Email</b></label>
								<input type="text" placeholder="Enter Email" name="mail" required>
								<label><b>New Password</b></label>
								<input type="password" placeholder="Enter New Password" name="newpwd" required>
								<button type="submit">Send mail</button>
							</div>
							<div class="form-container" style="background-color:#f1f1f1">
								<button type="button" onclick="document.getElementById('id03').style.display='none'" class="cancelbtn" style='width:100%'>Cancel</button>
							</div>
						</form>
					</div>

				</td>
			</tr>
		</table>

<script>

/************************************/
/* Affichage ou non des formulaires */
/************************************/
var modal1 = document.getElementById('id01');
var modal2 = document.getElementById('id02');
var modal3 = document.getElementById('id03');

window.onclick = function(event) {
	if (event.target == modal1 ||
		event.target == modal2 ||
		event.target == modal3) {
		modal1.style.display = "none";
		modal2.style.display = "none";
		modal3.style.display = "none";
	}
}

</script>
