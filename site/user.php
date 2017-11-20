<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('inc/util.inc.php');
require('inc/config.inc.php');
require('inc/session.inc.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!isset($_POST['api_action'])) {
		die('ERROR: api_action parameter missing');
	}

	if ($_POST['api_action'] == 'login') {
		if (!isset($_POST['user_id'])) {
			die('ERROR: user_id parameter missing');
		}

		if (!isset($_POST['password'])) {
			die('ERROR: password parameter missing');
		}

		try {
			$response = api('session', 'login', [
				'user_id' => $_POST['user_id'],
				'password' => $_POST['password']]);
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
	} else if ($_POST['api_action'] == 'logout') {
		api('session', 'logout', []);
		header('Location: .');
		die();
	} else {
		die('ERROR: invalid action: ' . htmspecialchars($_POST['api_action']));
	}
}

if ($is_user_logged_in) {
	$title = $user_name . ' – CCGWeb';
} else {
	$title = 'Login – CCGWeb';
}

require('inc/head.inc.php');
?>

<div class=container>

<?php if ($is_user_logged_in) { ?>

<p>Logged in as <?= htmlspecialchars($user_name) ?>.</p>

<form id=logout_form action=<?= $_SERVER['PHP_SELF'] ?> method=POST>
	<input type=hidden name=api_action value=logout>
	<button type=submit class="btn btn-default">Logout</button>
</form>

<?php } else { ?>

<h2>Login</h2>

<form id=login_form action=<?= $_SERVER['PHP_SELF'] ?> method=POST>
	<input type=hidden name=api_action value=login>
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

<?php } ?>

</div>

<?php
require('inc/foot.inc.php');
?>
