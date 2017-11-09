<?php
require('vendor/autoload.php');
require('inc/config.inc.php');
require('inc/util.inc.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$params = $_GET;

	if (!isset($params['api_resource'])) {
		http_response_code(400);
		die('ERROR: api_resource parameter missing');
	}

	$resource = $params['api_resource'];
	unset($params['api_resource']);

	try {
		$response = api($resource, 'get', $params);
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

	$resource = $params['api_resource'];
	unset($params['api_resource']);

	if (!isset($params['api_action'])) {
		http_response_code(400);
		die('ERROR: api_action parameter missing');
	}

	$action = $params['api_action'];
	unset($params['api_action']);

	try {
		$response = api($resource, $action, $params);
	} catch(Requests_Exception $e) {
		http_response_code(500);
		die('ERROR: could not connect to REST server. Is it running?');
	}

	http_response_code($response->status_code);

	if ($response->success) {
		echo $response->body;
	} else {
		die('ERROR: API error (' . $resource . ')');
	}
} else {
	die('ERROR: bad method');
}
?>
