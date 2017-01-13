<?php

session_start();

if (isset($_SESSION['login']) &&
	isset($_POST['overlay']) &&
	isset($_POST['effect']) &&
	isset($_POST['data']))
{
	$overlay = "../img/overlays/";
	$overlay .= basename($_POST['overlay']);
	$name = time() . '.png';
	$data = $_POST['data'];
	$user = $_SESSION['login'];
	$path = '../img/users/' . $user . '/';

	if (!file_exists($path))
	{
		mkdir($path, 0777, true);
	}

	$data = str_replace(' ', '+', $data);
	$data = str_replace('data:image/png;base64,','', $data);
	$data = base64_decode($data);

	function imagefilterhue($im,$r,$g,$b){
		$rgb = $r+$g+$b;
		$col = array($r/$rgb,$b/$rgb,$g/$rgb);
		$height = imagesy($im);
		$width = imagesx($im);
		for($x=0; $x<$width; $x++){
			for($y=0; $y<$height; $y++){
				$rgb = ImageColorAt($im, $x, $y);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;
				$newR = $r*$col[0] + $g*$col[1] + $b*$col[2];
				$newG = $r*$col[2] + $g*$col[0] + $b*$col[1];
				$newB = $r*$col[1] + $g*$col[2] + $b*$col[0];
				imagesetpixel($im, $x, $y, imagecolorallocate($im, $newR, $newG, $newB));
			}
		}
	}


	function apply_filter($img, $effect)
	{
		if ($effect == "grayscale") {								// OK
			imagefilter($img, IMG_FILTER_GRAYSCALE);
		}
		else if ($effect == "sepia") {								// OK
			imagefilter($img, IMG_FILTER_GRAYSCALE);
			imagefilter($img, IMG_FILTER_COLORIZE, 60, 40, 0);
		}
		else if ($effect == "brightness") {							// OK
			imagefilter($img, IMG_FILTER_BRIGHTNESS, -255 / 3.5);
		}
		else if ($effect == "contrast") {							// OK
			imagefilter($img, IMG_FILTER_BRIGHTNESS, 255 / 4);
		}
		else if ($effect == "hue-rotate") {							// OK
			imagefilterhue($img, 100, 100, 0);
		}
		else if ($effect == "hue-rotate2") {						// OK
			imagefilterhue($img, 0, 140, 80);
		}
		else if ($effect == "hue-rotate3") {
			imagefilterhue($img, 100, 100, 200);
		}
		else if ($effect == "saturate") {
		}
		else if ($effect == "invert") {
		}
	}

	function apply_overlay($picture, $overlay_path, $result_path)
	{
		$width_x = imagesx($picture);
		$height_x = imagesy($picture);

		list($width_y, $height_y) = getimagesize($overlay_path);

		$overlay_ratio = $width_y / $height_y;
		$picture_ratio = $width_x / $height_x;

		$result = imagecreatetruecolor($width_x, $height_x);

		$overlay = imagecreatefrompng($overlay_path);

		imagecopy($result, $picture, 0, 0, 0, 0, $width_x, $height_x);

		if (($overlay_ratio != $picture_ratio) &&
			($overlay_path != "frame1.png") &&
			($overlay_path != "frame2.png") &&
			($overlay_path != "frame3.png") &&
			($overlay_path != "frame4.png"))
		{
			if (($width_x / $width_y) < ($height_x / $height_y))
			{
				$ratio = $width_x / $width_y;
			}
			else
			{
				$ratio = $height_x / $height_y;
			}
			$new_x = $width_y * $ratio;
			$new_y = $height_y * $ratio;
			imagecopyresampled($result, $overlay, 0, 0, 0, 0, $new_x, $new_y, $width_y, $height_y);
		}
		else
		{
			imagecopyresampled($result, $overlay, 0, 0, 0, 0, $width_x, $height_x, $width_y, $height_y);
		}
		imagepng($result, $result_path);
		imagedestroy($result);
		imagedestroy($picture);
		imagedestroy($overlay);
	}

	$final_data = imagecreatefromstring($data);

	if ($final_data !== false)
	{
		apply_filter($final_data, $_POST['effect']);
		apply_overlay($final_data, $overlay, $path.$name);
	}

	require_once('../config/database.php');

	$DB = new PDO($DB_DSN, $DB_USR, $DB_PWD);
	$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $DB->prepare('INSERT INTO pictures (user, likes, path) VALUES (:user, :likes, :path)');
	$stmt->execute(array(':user' => $user, ':likes' => 0, ':path' => $path.$name));

	$DB = null;

	echo '<img src="' . $path.$name . '">';
	// close co
}
else {
	echo "an error occured";
}

?>
