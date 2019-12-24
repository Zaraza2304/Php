<?php
session_start();

$img = imageCreateFromJpeg("images/noise.jpg");
$color = imageColorAllocate($img, 74, 50, 50);
imageAntiAlias($img, true);

$c_char = 5;
$word = substr(md5(uniqid()), 0, $c_char);
$_SESSION["word"] = $word;

$x = 20;
$y = 30;

$size_word = strlen($word);
$font = "D:/Programs/OSPanel/domains/day3/gd/fonts/arial.ttf";

for($i = 0; $i <= $size_word; $i++) {
	$size = rand(16, 30);
	$angle = -30 + rand(0, 60);
	imageTtfText($img, $size, $angle, $x, $y, $color, $font, $word[$i]);
	$x += 40;
}


header("Content-type: image/jpg");
imageJpeg($img);