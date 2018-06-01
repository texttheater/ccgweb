<?php
session_start();

if (isset($_SESSION['ccgweb_api_session_id'])) {
	try {
		$response = Requests::get("$api/session", [
			'Cookie' => 'session_id=' . $_SESSION['ccgweb_api_session_id']
		]);
	} catch (Requests_Exception $e) {
		die('ERROR: could not connect to REST server. Is it running?');
	}
	
	if ($response->success) {
		$body = json_decode($response->body);
		
		if ($body && isset($body->user_id)) {
			$is_user_logged_in = true;
			$user_name = $body->user_id;
		} else {
			$is_user_logged_in = false;
		}
	} else {
		die('ERROR: login failed');
	}
} else {
	$is_user_logged_in = false;
}

$is_user_privileged = $is_user_logged_in && in_array($user_name, ['johan', 'kilian', 'lasha', 'judge']);

?>
