<?php

function get_page($page) {

	if (isset($page))
	{
		$page = htmlentities(htmlspecialchars($page));
		
		if (file_exists("pages/" . $page . ".php"))
		{
			include("pages/" . $page . ".php");
		}
		else
		{
			include("pages/404.php");
		}
	}
	else
	{
		include ("index.php");
	}
}

?>
