<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('inc/util.inc.php');
require('inc/config.inc.php');

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

$title = 'Login – CCGWeb';

require('inc/head.inc.php');
?>

<h1>Login</h1>

<form id=login_form action=<?= $_SERVER['PHP_SELF'] ?> method=POST>
	<p>
		<label for=user_id>Username</label><br>
		<input class=form-control type=text maxlength=32 name=user_id id=user_id>
	</p>
	<p>
		<label for=password>Password</label><br>
		<input class=form-control type=password name=password id=password>
	</p>
	<p>
		<button type=submit class="btn btn-default">Login</button>
	</p>
</form>

<?php
require('inc/foot.inc.php');
?>
