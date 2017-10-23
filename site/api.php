<?php
require('vendor/autoload.php');
require('inc/config.inc.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$params = $_GET;

	if (!isset($params['api_resource'])) {
		http_response_code(400);
		die('ERROR: api_resource parameter missing');
	}

	$resource = $params['api_resource'];
	unset($params['api_resource']);
	$query = http_build_query($params, null,
		ini_get('arg_separator.output'), PHP_QUERY_RFC3986);
	$headers = [];

	if (isset($_SESSION['ccgweb_api_session_id'])) {
		$headers['Cookie'] = 'session_id=' . $_SESSION['ccgweb_api_session_id'];
	}

	try {
		Requests::get($api . '/' . $resouce . '?' . $query, $headers);
	} catch(Requests_Exception $e) {
		http_response_code(500);
		die('ERROR: could not connect to REST server. Is it running?');
	}

	http_response_code($response->status_code);

	if ($response->success) {
		echo $response->body;
	} else {
		die ('ERROR: API error (' . $resource . '?' . $query . ')');
	}
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$params = $_POST;

	if (!isset($params['api_resource'])) {
		http_response_code(400);
		die('ERROR: api_resource parameter missing');
	}

	if (!isset($params['api_action'])) {
		http_response_code(400);
		die('ERROR: api_action parameter missing');
	}

	$resource = $params['api_resource'];
	unset($params['api_resource']);
	$headers = [];

	if (isset($_SESSION['ccgweb_api_session_id'])) {
		$headers['Cookie'] = 'session_id=' . $_SESSION['ccgweb_api_session_id'];
	}

	try {
		$response = Requests::post("$api/" . $resource, $headers, $params);
	} catch(Requests_Exception $e) {
		http_response_code(500);
		die('ERROR: could not connect to REST server. Is it running?');
	}

	http_response_code($response->status_code);

	if ($response->success) {
		echo $response->body;
	} else {
		die ('ERROR: API error (' . $resource . ')');
	}
} else {
	die('ERROR: bad method');
}
?>
