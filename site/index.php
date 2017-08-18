<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('util.inc.php');
require('config.inc.php');

if (!$_GET['sentence']) {
	die('ERROR: sentence parameter must be given');
}

if (strlen($_GET['sentence']) > 1024) {
	die('ERROR: sentence too long. Only 1024 bytes allowed.');
}

$sentence = $_GET['sentence'];

$response = Requests::get("$api/sentences/" . urlencode($sentence));

if (!$response->success) {
	die('ERROR: bad API response status');
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>CCGWeb</title>
		<link rel=stylesheet href=css/main.css>
		<link rel=stylesheet href=css/der.css>
	</head>
	<body>
		<main>
			<?= xslTransform('xsl/der.xsl', $response->body) ?>
		</main>
	</body>
</html>
