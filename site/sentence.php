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

<?php
if ($is_user_logged_in) {
	$active_tab = $user_name;
} else {
	$active_tab = 'auto';
}
?>

<ul class="nav nav-tabs">
	<?php $i = 0; foreach($body->annotations as $annotation) { ?>
		<?php $mine = $annotation->user_id == $active_tab ?>
		<li class="<?= $mine ? 'active' : '' ?>">
			<a data-toggle=tab href=#parse<?= $i ?>>
				<?= htmlspecialchars($annotation->user_id) ?>
			</a>
		</li>
	<?php $i++; } ?>
</ul>

<div class=tab-content>
	<?php $i = 0; foreach($body->annotations as $annotation) { ?>
		<?php $mine = $annotation->user_id == $active_tab ?>
		<div id=parse<?= $i ?> class="tab-pane <?= $mine ? 'active editable' : '' ?>">
			<?php if ($is_user_logged_in && $mine) { ?>
				<div id=derivation-controls>
					<div class=checkbox>
						<label>
							<input type=checkbox id=mark-correct <?= $annotation->marked_correct ? 'checked' : '' ?>>
							<span class="label <?= $annotation->marked_correct ? 'label-success' : 'label-default' ?>">
								mark correct
							</span>
						</label>
					</div>
					<div>
						&nbsp;
						&nbsp;
<?php
$url = url('https://texttheater.net/ccgweb/sentence.php', ['lang' => $lang, 'sentence' => $sentence]);
?>
						<a href=<?= url('https://github.com/texttheater/ccgweb/issues/new', ['title' => "[$lang] $sentence", 'body' => "[$url]($url)" . "\n\n"]) ?>>report issue</a>
						&nbsp;
						&nbsp;
						<a id=reset-link href=#>reset</a>
					</div>
				</div>
			<?php } ?>
			<?= xslTransform('xsl/der.xsl', $annotation->derxml) ?>
			<!--<code><?= htmlspecialchars(json_encode($annotation->constituents)) ?></code>-->
		</div>
	<?php $i++; } ?>
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
	<a href="<?= url('sentence.php', ['lang' => $body->prev->lang, 'sentence' => $body->prev->sentence]) ?>">
		Previous
	</a>
</li>

<?php } ?>

<?php if (isset($body->next)) { ?>

<li class=page-item>
	<a href="<?= url('sentence.php', ['lang' => $body->next->lang, 'sentence' => $body->next->sentence]) ?>">
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
