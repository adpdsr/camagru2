<html>
<head>
<link rel='stylesheet' href='css/gallery.css'>
</head>
<body>

<?php

require('./config/database.php');
require_once('includes/functions/db_connexion.php');

try
{
	// Connexion to database
	$dbc = dbConnexion($DB_DSN, $DB_USR, $DB_PWD);

	// Find out how many items are in the table
	$total = $dbc->query('SELECT COUNT(*) FROM `pictures`')->fetchColumn();

	if ($total != 0)
	{
		// How many items to list per page
		$limit = 8;

		// How many pages will there be
		$pages = ceil($total / $limit);

		// What page are we currently on?
		$page = min($pages, filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT,
			array('options' => array('default' => 1, 'min_range' => 1,),)));

		// Calculate the offset for the query
		$offset = ($page - 1)  * $limit;

		// Some information to display to the user
		$start = $offset + 1;
		$end = min(($offset + $limit), $total);

		// The "back" link
		$prevlink = ($page > 1) ? '<a href="index.php?page=gallery&id=1" title="First page">&laquo;</a>
			<a href="index.php?page=gallery&id=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '
			<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

		// The "forward" link
		$nextlink = ($page < $pages) ? '<a href="index.php?page=gallery&id=' . ($page + 1) . '" title="Next page">&rsaquo;</a>
			<a href="index.php?page=gallery&id=' . $pages . '" title="Last page">&raquo;</a>' : 
			'<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

		// Prepare the paged query
		$stmt = $dbc->prepare('SELECT * FROM `pictures` ORDER BY `date` DESC LIMIT :limit OFFSET :offset');

		// Bind the query params
		$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
		$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
		$stmt->execute();

		echo "<div style='margin-top:100px; width:80%; margin-left:10%'>";

		// Do we have any results?
		if ($stmt->rowCount() > 0)
		{
            // Define how we want to fetch the results
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$iterator = new IteratorIterator($stmt);

			// Display the results
			foreach ($iterator as $row)
			{
				$pic_name = substr($row['path'], 3);
				echo "<div class='responsive'>
					<div class='img'>
					<a target='' href='pages/test.php?picture=".$pic_name."'><img src='".$pic_name."' alt='' width='300' height='200'></a>";

				if ($_SESSION['login'] !== null) {
				    echo "
                        <form method='post' action='actions/likes.php' style='margin-bottom:5px;'>
                        <input type='submit' name='".$pic_name."' value='like' style='width:100%; margin-top:5px;'/>
                        </form>
                        <form method='post' action='actions/comment.php' style='margin-bottom:0px;'>
                        <textarea placeholder='type your comment here' style='width: 100%;' name='comment' required></textarea>
                        <input type='submit' name='".$pic_name."'/ style='width:100%; margin-top:5px;'>
                        </form>";
				}

				echo "
                    <br>
					<span class='badge'>" . $row['likes'] . "</span>
					</div>
					</div>
                ";
			}

			echo '<div class="clearfix"></div>';
			echo '<div style="text-align:center; color: floralwhite; padding: 10px 0 10px 0;margin: 0 6px 0 6px; background-color: #292c2f; border-radius: 10px">';
			echo '<p>', $prevlink, '&nbsp&nbsp', ' Page ', $page, ' sur ', $pages, '&nbsp&nbsp', $nextlink, '</p></div>';
			echo "</div>";
		}
		else {
			echo '<div><center>Aucunes photos disponibles</center></div>';
		}
	}
	else
	{
		echo '<div><center>Aucunes photos disponibles</center></div>';
	}
}
catch (Exception $e) {
	echo '<p>', $e->getMessage(), '</p>';
}

$dbc = null;

?>
</body>
</html>
