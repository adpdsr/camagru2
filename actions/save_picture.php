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

	function rgb2hsl($r, $g, $b) {
		$var_R = ($r / 255);
		$var_G = ($g / 255);
		$var_B = ($b / 255);

		$var_Min = min($var_R, $var_G, $var_B);
		$var_Max = max($var_R, $var_G, $var_B);
		$del_Max = $var_Max - $var_Min;

		$v = $var_Max;

		if ($del_Max == 0) {
			$h = 0;
			$s = 0;
		} else {
			$s = $del_Max / $var_Max;

			$del_R = ( ( ( $var_Max - $var_R ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
			$del_G = ( ( ( $var_Max - $var_G ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
			$del_B = ( ( ( $var_Max - $var_B ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;

			if      ($var_R == $var_Max) $h = $del_B - $del_G;
			else if ($var_G == $var_Max) $h = ( 1 / 3 ) + $del_R - $del_B;
			else if ($var_B == $var_Max) $h = ( 2 / 3 ) + $del_G - $del_R;

			if ($h < 0) $h++;
			if ($h > 1) $h--;
		}

		return array($h, $s, $v);
	}

	function hsl2rgb($h, $s, $v) {
		if($s == 0) {
			$r = $g = $B = $v * 255;
		} else {
			$var_H = $h * 6;
			$var_i = floor( $var_H );
			$var_1 = $v * ( 1 - $s );
			$var_2 = $v * ( 1 - $s * ( $var_H - $var_i ) );
			$var_3 = $v * ( 1 - $s * (1 - ( $var_H - $var_i ) ) );

			if       ($var_i == 0) { $var_R = $v     ; $var_G = $var_3  ; $var_B = $var_1 ; }
			else if  ($var_i == 1) { $var_R = $var_2 ; $var_G = $v      ; $var_B = $var_1 ; }
			else if  ($var_i == 2) { $var_R = $var_1 ; $var_G = $v      ; $var_B = $var_3 ; }
			else if  ($var_i == 3) { $var_R = $var_1 ; $var_G = $var_2  ; $var_B = $v     ; }
			else if  ($var_i == 4) { $var_R = $var_3 ; $var_G = $var_1  ; $var_B = $v     ; }
			else                   { $var_R = $v     ; $var_G = $var_1  ; $var_B = $var_2 ; }

				$r = $var_R * 255;
			$g = $var_G * 255;
			$B = $var_B * 255;
		}    
		return array($r, $g, $B);
	}

	function imageSaturation($image, $sat)
	{
		$width = imagesx($image);
		$height = imagesy($image);
		for ($x = 0; $x < $width; $x++)
		{
			for ($y = 0; $y < $height; $y++)
			{
				$rgb = imagecolorat($image, $x, $y);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;
				$alpha = ($rgb & 0x7F000000) >> 24;
				list($h, $s, $l) = rgb2hsl($r, $g, $b);
				$s = $s * (100 + $sat) /100;
				if ($s > 1)
					$s = 1;
				list($r, $g, $b) = hsl2rgb($h, $s, $l);
				imagesetpixel($image, $x, $y, imagecolorallocatealpha($image, $r, $g, $b, $alpha));
			}
		}
	}

	function imagefilterhue($im,$r,$g,$b)
	{
		$rgb = $r+$g+$b;
		$col = array($r/$rgb,$b/$rgb,$g/$rgb);
		$height = imagesy($im);
		$width = imagesx($im);
		for ($x=0; $x<$width; $x++)
		{
			for ($y=0; $y<$height; $y++)
			{
				$rgb = imagecolorat($im, $x, $y);
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
			imagefilterhue($img, 0, 200, 0);
		}
		else if ($effect == "hue-rotate2") {						// OK
			imagefilterhue($img, 0, 255, 255);
		}
		else if ($effect == "hue-rotate3") {						// OK
			imagefilterhue($img, 0, 0, 255);
		}
		else if ($effect == "saturate") {
			imageSaturation($img, 1500);
		}
		else if ($effect == "invert") {
			imagefilter($img, IMG_FILTER_NEGATE);
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

	$date = date("Y-m-d H:i:s");

	$DB = new PDO($DB_DSN, $DB_USR, $DB_PWD);
	$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $DB->prepare('INSERT INTO pictures (user, likes, path, date) VALUES (:user, :likes, :path, :date)');
	$stmt->execute(array(':user' => $user, ':likes' => 0, ':path' => $path.$name, ':date' => $date));

	$DB = null;

	echo '<img src="' . $path.$name . '">';
	// close co
}
else {
	echo "an error occured";
}

?>
