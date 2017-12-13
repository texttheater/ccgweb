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

$title = 'CCGWeb';

require('inc/head.inc.php');
?>

<div class=container>

<h2>Sentences to Annotate</h2>

<ul class=list-unstyled>

<?php
foreach ($assignment as $sentence) {
?>

<li>
	<span class="label label-primary">
		<?= htmlspecialchars($sentence->lang) ?>
	</span>
	&nbsp;
	<a href=sentence.php?lang=<?= rawurlencode($sentence->lang) ?>&sentence=<?= rawurlencode($sentence->sentence) ?>>
		<?= htmlspecialchars($sentence->sentence) ?>
	</a>

<?php
if ($sentence->done) {
?>

<span class="label label-success">marked correct</span>

<?php
}
?>

</li>
	
<?php
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
