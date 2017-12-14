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

$title = 'CCGWeb - ' . htmlspecialchars($sentence);

require('inc/head.inc.php');
?>

<div class=container>

<h2>Sentence</h2>

<p><span class="label label-default"><?= $lang ?></span> <?= htmlspecialchars($sentence); ?></p>

<hr>

<h2>Parse</h2>

<ul class="nav nav-tabs">
	<li class="<?= $is_user_logged_in ? '' : 'active' ?>"><a data-toggle=tab href=#parses_parser>Parser</a></li>
	<?php if ($is_user_logged_in) { ?>
		<li class=active><a data-toggle=tab href=#parses_mine>Mine</a></li>
	<?php } ?>
</ul>
<div class=tab-content>
	<div id=parses_parser class="tab-pane <?= $is_user_logged_in ? '' : 'active' ?>">
		<?= xslTransform('xsl/der.xsl', $body->auto_derxml) ?>
	</div>
	<?php if ($is_user_logged_in) { ?>
		<div id=parses_mine class="tab-pane active">
			<!--<p><form class=form-inline>-->
				<div class=checkbox>
					<label>
						<input type=checkbox id=mark-correct <?= $body->marked_correct ? 'checked' : '' ?>>
						<span class="label <?= $body->marked_correct ? 'label-success' : 'label-default' ?>">
							mark correct
						</span>
					</label>
					&nbsp;
					<a href=<?= url('https://github.com/texttheater/ccgweb/issues/new', ['title' => "[$lang] $sentence", 'body' => url('https://texttheater.net/ccgweb/sentence.php', ['lang' => $lang, 'sentence' => $sentence]) . "\n\n"]) ?>>report issue</a>
				</div>
			<!--</form></p>-->
			<?= xslTransform('xsl/der.xsl', $body->user_derxml) ?>
		</div>
	<?php } ?>
</div>

<hr>

<h2>Translations</h2>

<ul class=list-unstyled>
<?php
foreach($body->translations as $translation) {
	print_link_to_sentence($translation);
}
?>
</ul>

<hr>

<nav aria-label="Navigation through sentences">
	<ul class="pagination">

<?php if (isset($body->prev)) { ?>

<li class=page-item>
	<a href="<?= url('sentence.php', ['lang' => $lang, 'sentence' => $body->prev]) ?>">
		Previous
	</a>
</li>

<?php } ?>

<?php if (isset($body->next)) { ?>

<li class=page-item>
	<a href="<?= url('sentence.php', ['lang' => $lang, 'sentence' => $body->next]) ?>">
		Next
	</a>
</li>

<?php } ?>

	</ul>
</nav>

</div>

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
