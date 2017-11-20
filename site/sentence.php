<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('inc/util.inc.php');
require('inc/config.inc.php');
require('inc/session.inc.php');

if (!isset($_GET['lang']) || !$_GET['lang']) {
	die('ERROR: lang parameter must be given.');
}

if (!isset($_GET['sentence']) || !$_GET['sentence']) {
	die('ERROR: sentence parameter must be given.');
}

if (!in_array($_GET['lang'], ['eng', 'deu', 'ita', 'nld'])) {
	die('ERROR: lang parameter must be one of eng, deu, ita, nld.');
}

if (strlen($_GET['sentence']) > 1024) {
	die('ERROR: sentence too long. Only 1024 bytes allowed.');
}

$lang = $_GET['lang'];
$sentence = $_GET['sentence'];

try {
	$response = api("sentences/$lang/" . rawurlencode($sentence), 'get', []);
} catch (Requests_Exception $e) {
	die('ERROR: could not connect to REST server. Is it running?');
}

if (!$response->success) {
	die('ERROR: bad API response status');
}

$body = json_decode($response->body);

$parser_sentence = $body->auto_derxml;

if ($is_user_logged_in) {
	$user_sentence = $body->user_derxml;
}

$title = 'CCGWeb - ' . htmlspecialchars($sentence);

require('inc/head.inc.php');
?>

<div id=nav-arrows>

<?php if (isset($body->prev)) { ?>

	<a class=nav-arrow id=nav-arrow-prev href="<?= sitelink('sentence', ['lang' => $lang, 'sentence' => $body->prev]) ?>">
		<span class="glyphicon glyphicon-arrow-left" title="previous sentence" aria-hidden="true"></span>
		<span class=sr-only>previous sentence</span>
	</a>

<?php } ?>

<?php if (isset($body->next)) { ?>

		<a class=nav-arrow id=nav-arrow-next href="<?= sitelink('sentence', ['lang' => $lang, 'sentence' => $body->next]) ?>">
		<span class="glyphicon glyphicon-arrow-right" title="next sentence" aria-hidden="true"></span>
		<span class=sr-only>next sentence</span>
	</a>

<?php } ?>

</div>

<main>

<h2>Sentence</h2>

<p><span class="label label-default"><?= $lang ?></span> <?= htmlspecialchars($sentence); ?></p>

<h2>Parse</h2>

<ul class="nav nav-tabs">
	<li class="<?= $is_user_logged_in ? '' : 'active' ?>"><a data-toggle=tab href=#parses_parser>Parser</a></li>
	<?php if ($is_user_logged_in) { ?>
		<li class=active><a data-toggle=tab href=#parses_mine>Mine</a></li>
	<?php } ?>
</ul>
<div class=tab-content>
	<div id=parses_parser class="tab-pane <?= $is_user_logged_in ? '' : 'active' ?>">
		<?= xslTransform('xsl/der.xsl', $parser_sentence) ?>
	</div>
	<?php if ($is_user_logged_in) { ?>
		<div id=parses_mine class="tab-pane active">
			<?= xslTransform('xsl/der.xsl', $user_sentence) ?>
			<p>&nbsp;</p>
			<div class=checkbox style="display: inline;" id=mark-correct>
				<label>
					<input type=checkbox <?= $body->marked_correct ? 'checked' : '' ?>>
					<span class="label <?= $body->marked_correct ? 'label-success' : 'label-default' ?>">
						mark correct
					</span>
				</label>
			</div>
		</div>
	<?php } ?>
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
