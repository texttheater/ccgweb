<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('util.inc.php');
require('config.inc.php');

require('session.inc.php');

if (!isset($_GET['sentence']) || !$_GET['sentence']) {
	die('ERROR: sentence parameter must be given');
}

if (strlen($_GET['sentence']) > 1024) {
	die('ERROR: sentence too long. Only 1024 bytes allowed.');
}

$sentence = $_GET['sentence'];

try {
	$response = Requests::get("$api/sentences/" . rawurlencode($sentence));
} catch (Requests_Exception $e) {
	die('ERROR: could not connect to REST server. Is it running?');
}

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
		<script>
<?php
if ($is_user_logged_in) {
	echo "const isUserLoggedIn = true\n";
	echo "const userName = ". json_encode($user_name) . "\n";
} else {
	echo "const isUserLoggedIn = false\n";
}
?>
		</script>
	</head>
	<body>
		<main>
			<?= xslTransform('xsl/der.xsl', $response->body) ?>
		</main>
		<script src=js/der.js></script>
	</body>
</html>
