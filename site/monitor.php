<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('inc/util.inc.php');
require('inc/config.inc.php');
require('inc/session.inc.php');

if (!$is_user_logged_in || $user_name != 'judge') {
	header('Location: user.php');
	die();
}

try {
	$response = api('monitor', 'get', []);
} catch (Requests_Exception $e) {
	die('ERROR: could not connect to REST server. Is it running?');
}

if (!$response->success) {
	die('ERROR: bad API response status');
}

$body = json_decode($response->body);

$title = 'CCGWeb - Monitor';
require('inc/head.inc.php');
?>

<div class=container>

<h2>Monitor</h2>

<table class=table>
	<tr>
		<th>user</th>
		<th>lang</th>
		<th>assigned sentences marked correct</th>
	</tr>
<?php foreach ($body as $row) { ?>
	<tr>
		<td><?= htmlspecialchars($row->user_id) ?></td>
		<td><?= htmlspecialchars($row->lang) ?></td>
		<td><?= htmlspecialchars($row->count) ?></td>
	</tr>
<?php } ?>
</table>

</div>

<?php
require('inc/foot.inc.php');
?>
