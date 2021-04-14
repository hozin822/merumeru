<?php
require('lib.php');

if(isset($_POST['getCount'])) {

	if(RECORD_MODE == 'db') {
		$count = getCountDB();
	} else if(RECORD_MODE == 'file') {
		$count = getCountFile();
	} else {
		$count = getCountFile();
	}

	header('Content-Type: application/json; charset=utf-8');
	print_r('{"count":'. $count .'}');
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Уведомления</title>

	<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">

	<style>
		html {
			font-family: Roboto, sans-serif;
			background-color: #1c1c1c;
			color: #fff;
		}

		.main__h1 {
			color: #ff9800;
		}

		.main__span-contact {
			color: #4caf50;
			font-weight: bold;
		}
	</style>
</head>
<body class="main">

	<center>
		<h2 class="main__h1">Уведомления</h2>
		<p>Как только придут новые данные - услышишь звук.</p>
		<p>Не закрой случайно страницу :)</p>

		<br><br><br><br>

		<h4>Контакты разработчика: (по всем вопросам ^^)</h4>
		<p>
			Telegram: <span class="main__span-contact">stee_ucky</span>
			<br>
			Jabber: <span class="main__span-contact">stee.ucky@xmpp.jp</span>
		</p>
	</center>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		var count = 0;

		// INIT
		(function() {
			$.ajax({
				'url'   : '/CORE/notify.php',
				'data'  : 'getCount',
				'method': 'POST',

				'success': function(res) {
					count = res.count;

					setInterval(function() {
						main();
					}, 1000);
				}
			});
		})();

		function main() {
			$.ajax({
				'url'   : '/CORE/notify.php',
				'data'  : 'getCount',
				'method': 'POST',

				'success': function(res) {
					var newCount = res.count;

					if(newCount != count) {
						count = newCount;

						var audio = new Audio();
						audio.src = '/CORE/assets/notify/audio.mp3';
						audio.autoplay = true;
					}
				}
			});
		}
	</script>
</body>
</html>