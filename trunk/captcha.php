<?php
// 生成验证码

// session_save_path('./tmp/sessions');
session_start();
header('Content-type: image/png'); 
$code_num = 5;
$img_width = 114;
$img_height = 28;
$captcha_code = strtoupper(substr(md5(rand()), 0, $code_num));
$_SESSION['captcha'] = $captcha_code;
//echo $captcha_code; exit;
$im = imagecreate($img_width, $img_height);
imagecolorallocate($im, 255, 255, 255);
for ($i = 0; $i < 220; $i++) {
	$noice = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
	imagesetpixel($im, rand(0, $img_width), rand(0, $img_height), $noice);
}
for ($i = 0; $i < $code_num; $i++) {
	$font_color = imagecolorallocate($im, rand(0, 255), rand(0, 128), rand(0, 255));
	$x = floor($img_width / $code_num) * $i + 10;
	$y = rand(0, $img_height - 15);
	imagechar($im, 16, $x, $y, $captcha_code[$i], $font_color);
}
imagepng($im);
imagedestroy($im);
?>