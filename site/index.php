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

<main>

<div class=container>

<h2>My Assignment</h2>

<ul class=list-unstyled>

<?php
foreach ($assignment as $sentence) {
?>

<li>
	<span class="label label-default">
		<?= htmlspecialchars($sentence->lang) ?>
	</span>
	&nbsp;
	<a href=sentence.php?lang=<?= rawurlencode($sentence->lang) ?>&sentence=<?= rawurlencode($sentence->sentence) ?>>
		<?= htmlspecialchars($sentence->sentence) ?>
	</a>

<?php
if ($sentence->done) {
?>

<span class="glyphicon glyphicon-ok" title="done" aria-hidden="true"></span>
<span class="sr-only">done</span>

<?php
}
?>

</li>
	
<?php
}
?>

</ul>

</div>

</main>

<?php
require('inc/js.inc.php');
?>

<script>
<?php
echo "const sentence = " . json_encode($sentence) . "\n";
echo "const lang = " . json_encode($lang) . "\n";
?>
</script>

<script src=js/der.js></script>

<?php
require('inc/foot.inc.php');
?>
