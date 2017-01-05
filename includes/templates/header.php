<div class="fixed-header">
	<div class="container">
		<h1><a href="#">Cama<span>gru</span></a></h1>

<?php
if (isset($_SESSION['login']))
{
	echo "<nav>
		<a href='actions/logout.php' style='color:#A0140D;'>Logout</a>
		<a href='../../index.php?page=profile'>Profile</a>
		<a href='../../index.php?page=gallery'>Gallery</a>
		<a href='../../index.php?page=home'>Home</a>
	</nav>";
}
?>

	</div>
</div>
