<?php
session_start();

$captcha = $_SESSION['sessCaptcha'];
$captchaEntered = $_POST['captcha'];

if($captcha == $captchaEntered)
	echo "Captcha Matched!";
else
	echo "Captcha not Matched!";

?>