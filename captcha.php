<?php

session_start();
header('Content-type: image/jpeg');

$_SESSION['captcha']=rand(1000,9999);
$text=$_SESSION['captcha'];

$font_size = rand(25,30);

$image_width = 130;
$image_height = 100;

$image_angle = rand(-20,20);

if($image_angle<0)
{
	$y_offset = rand(30,50);
}
else
{
	$y_offset = rand(50,90);
}

$x_offset = rand(15,20);

$image = imagecreate($image_width, $image_height);

imagecolorallocate($image, 255, 255, 255);

$font_color = rand(1,3);

switch ($font_color) {
	case 1:
		$text_color = imagecolorallocate($image, 0, 0, 0);
		break;

	case 2:
		$text_color = imagecolorallocate($image, 0, 0, 255);
		break;

	case 3:
		$text_color = imagecolorallocate($image, 255, 0, 0);
		break;
	
	default:
		$text_color = imagecolorallocate($image, 0, 0, 0);
		break;
}

$number_of_lines = rand(11,15);

for($i=0; $i<$number_of_lines; $i++)
{
	$x1 = rand(1,130);
	$y1 = rand(1,100);
	$x2 = rand(1,130);
	$y2 = rand(1,100);

	imageline($image, $x1, $y1, $x2, $y2, $text_color);
}

$font_number = rand(1,3);
$font_name = 'font'.$font_number.'.ttf';

imagettftext($image, $font_size, $image_angle, $x_offset, $y_offset, $text_color, realpath($font_name), $text);  //We need font file for this.....
imagejpeg($image);

?>