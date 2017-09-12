<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('util.inc.php');
require('config.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST'
	&& $_POST['user_id']
	&& $_POST['password']) {
	try {
		$data = [
			'user_id' => $_POST['user_id'],
			'password' => $_POST['password'],
		];
		$response = Requests::post("$api/login", [], $data);
	} catch (Requests_Exception $e) {
		die('ERROR: could not connect to REST server. Is it running?');
	}

	if ($response->success) {
		$body = json_decode($response->body);
		$session_id = $body->session_id;
		session_start();
		$_SESSION['ccgweb_api_session_id'] = $session_id;
		header('Location: .');
		die();
	} else {
		die('ERROR: login failed');
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Login – CCGWeb</title>
		<link rel=stylesheet href=css/main.css>
	</head>
	<body>
		<main>
			<h1>Login – CCGWeb</h1>
			<form id=login_form action=<?= $_SERVER['PHP_SELF'] ?> method=POST>
				<label for=user_id>Username</label>
				<input type=text maxlength=32 name=user_id id=user_id>
				<label for=password>Password</label>
				<input type=password name=password id=password>
				<input type=submit value=Login>
			</form>
		</main>
	</body>
</html>
