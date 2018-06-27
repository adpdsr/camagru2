<div class="fixed-header">
	<div class="container">
		<h1><a href="http://localhost:8080/camagru/index.php">Cama<span>gru</span></a></h1>

<?php

if (isset($_SESSION['login'])) {
	echo "<nav>
		<a href='actions/logout.php' style='color:#A0140D;'>Logout</a>
		<a href='index.php?page=account'>Mon compte</a>
		<a href='index.php?page=profile'>Profile</a>
		<a href='index.php?page=gallery'>Gallerie</a>
		<a href='index.php?page=home'>Accueil</a>
	</nav>";
} else {
    echo "<nav>
		<a href='index.php?page=gallery'>Gallerie</a>
	</nav>";
}

?>

	</div>
</div>
