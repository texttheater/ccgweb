<?php
# uncomment for debugging
ini_set('display_errors', 'On');
error_reporting(E_ALL);

umask(2);

$errors = [];

if (!isset($_GET['sentence'])) {
	die('no sentence parameter given');
}

if (strlen($_GET['sentence']) > 1024) {
	die('sentence too long - only 1024 bytes allowed');
}

$sentence = $_GET['sentence'];
$hash = md5($sentence);
$base = 'out/' . substr($hash, 0, 2) . '/' . $hash;
$logbase = 'log/' . substr($hash, 0, 2) . '/' . $hash;
$raw = "$base.raw";
$log = "$logbase.log";
$derxml = "$base.der.xml";

if (!file_exists($raw)) {
	mkdir(dirname($raw));
	mkdir(dirname($log));
	file_put_contents($raw, $sentence);
}

shell_exec("./ext/produce/produce $derxml 2> $log");
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>CCGWeb</title>
		<link rel=stylesheet href=css/ccgweb.css>
		<link rel=stylesheet href=css/der.css>
	</head>
	<body>
		<main>

<?php
echo `xsltproc src/xslt/der.xsl $base.der.xml`;
?>

		</main>
	</body>
</html>
