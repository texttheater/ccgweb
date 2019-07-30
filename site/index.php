<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('inc/util.inc.php');
require('inc/config.inc.php');
require('inc/session.inc.php');

try {
	$response = api('assignment', 'get', []);
} catch (Requests_Exception $e) {
	die('ERROR: could not connect to REST server. Is it running?');
}

if (!$response->success) {
	die('ERROR: bad API response status');
}

$assignment = json_decode($response->body);

$title = 'CCGweb';

require('inc/head.inc.php');
?>

<div class=container>

<h2>Sentences to Annotate</h2>

<ul class=list-unstyled>

<?php
foreach ($assignment as $sentence) {
	print_link_to_sentence($sentence, $is_user_logged_in);
}
?>

</ul>

</div>

<?php
require('inc/js.inc.php');
?>

<?php
require('inc/foot.inc.php');
?>
