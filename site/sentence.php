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

$title = 'CCGWeb - ' . $sentence;

require('inc/head.inc.php');
?>

<div class=container>

<h2>Sentence</h2>

<div class="row">
	<div class="col-md-9">
		<form id="sentence-edit" class="form-inline" action="sentence.php" method="GET">
			<select name="lang">
				<option value="ara" <?= selected($lang, 'ara') ?>>ara</option>
				<option value="bul" <?= selected($lang, 'bul') ?>>bul</option>
				<option value="dan" <?= selected($lang, 'dan') ?>>dan</option>
				<option value="eng" <?= selected($lang, 'eng') ?>>eng</option>
				<option value="est" <?= selected($lang, 'est') ?>>est</option>
				<option value="deu" <?= selected($lang, 'deu') ?>>deu</option>
				<option value="fra" <?= selected($lang, 'fra') ?>>fra</option>
				<option value="hin" <?= selected($lang, 'hin') ?>>hin</option>
				<option value="ind" <?= selected($lang, 'ind') ?>>ind</option>
				<option value="ita" <?= selected($lang, 'ita') ?>>ita</option>
				<option value="kan" <?= selected($lang, 'kan') ?>>kan</option>
				<option value="ltz" <?= selected($lang, 'ltz') ?>>ltz</option>
				<option value="mar" <?= selected($lang, 'mar') ?>>mar</option>
				<option value="nld" <?= selected($lang, 'nld') ?>>nld</option>
				<option value="pol" <?= selected($lang, 'pol') ?>>pol</option>
				<option value="por" <?= selected($lang, 'por') ?>>por</option>
				<option value="ron" <?= selected($lang, 'ron') ?>>ron</option>
				<option value="rus" <?= selected($lang, 'rus') ?>>rus</option>
				<option value="spa" <?= selected($lang, 'spa') ?>>spa</option>
				<option value="srp" <?= selected($lang, 'srp') ?>>srp</option>
				<option value="tur" <?= selected($lang, 'tur') ?>>tur</option>
				<option value="urd" <?= selected($lang, 'urd') ?>>urd</option>
				<option value="vie" <?= selected($lang, 'vie') ?>>vie</option>
			</select>
			<input type="text" dir="auto" name="sentence" size="60" value="<?= htmlspecialchars($sentence) ?>">
			<button type="submit">Go</button>
		</form>
	</div>
	<div class="col-md-3 text-right">
		<div class="btn-group">

<?php
if (isset($body->prev)) {
?>

			<a class="btn btn-default" href="<?= url('sentence.php', ['lang' => $body->prev->lang, 'sentence' => $body->prev->sentence]) ?>">Previous</a>

<?php
}
?>

<?php
if (isset($body->next)) {
?>

			<a class="btn btn-default" href="<?= url('sentence.php', ['lang' => $body->next->lang, 'sentence' => $body->next->sentence]) ?>">Next</a>

<?php
}
?>

		</div>
	</div>
</div>

<hr>

<h2>Parse</h2>

<ul class="nav nav-tabs">

<?php
$annotations_count = count($body->annotations);
$human_annotations_count = 0;
foreach ($body->annotations as $annotation) {
	$human_annotations_count += is_human_user_id($annotation->user_id);
}
for ($i = 0; $i < $annotations_count; $i++) {
	$annotation = $body->annotations[$i];
?>

		<li class="<?= $annotation->user_id == $body->active_version ? 'active' : '' ?>">
			<a data-toggle=tab href=#parse<?= $i ?>>
				<?= htmlspecialchars($annotation->user_id) ?>
			</a>
		</li>

<?php
}
?>

</ul>

<div class=tab-content>

<?php
for ($i = 0; $i < $annotations_count; $i++) {
	$annotation = $body->annotations[$i];
	$active = $annotation->user_id == $body->active_version;
	$editable = $is_user_logged_in && $annotation->user_id == $user_name;
	$derivation_html = xslTransform('xsl/der.xsl', $annotation->derxml);
?>

<div id="parse<?= $i ?>" class="parse tab-pane<?= $active ? ' active' : '' ?><?= $editable ? ' editable' : '' ?>" data-user_id="<?= htmlspecialchars($annotation->user_id) ?>">
	<div class="derivation-controls btn-toolbar">

<?php
	if ($editable) {
		$url = url('https://texttheater.net/ccgweb/sentence.php', ['lang' => $lang, 'sentence' => $sentence]);
		$issue_url = url('https://github.com/texttheater/ccgweb/issues/new', ['title' => "[$lang] $sentence", 'body' => "[$url]($url)\n\n"]);
?>

		<div class="btn-group">
			<button class="btn <?= $annotation->marked_correct ? 'btn-success' : 'btn-default' ?> btn-sm" id="mark-correct">mark correct</button>
			<a class="btn btn-default btn-sm" href="<?= $issue_url ?>">report issue</a>
			<a class="btn btn-default btn-sm" id="reset-link" href=#>reset</a>
		</div>

<?php
	}
?>

		<div class="btn-group">
			<button class="btn btn-primary btn-sm view-button" data-view-type="visual">visual</button>
			<button class="btn btn-default btn-sm view-button" data-view-type="html">HTML</button>
			<button class="btn btn-default btn-sm view-button" data-view-type="latex">LaTeX</button>
		</div>
	</div>

<?php
	if ($is_user_logged_in && $user_name == 'judge' && $human_annotations_count < 2) {
?>

	<div class="alert alert-warning" role="alert">
		This sentence has not yet been annotated by 2 annotators.
	</div>

<?php
	}
?>

	<div class="view view-active" data-view-type="visual">
		<?= $derivation_html ?>
	</div>
	<div class="view" data-view-type="html">
		<textarea class="form-control" readonly rows="10"><?= htmlspecialchars($derivation_html) ?></textarea>
		<p>Use with <a href="css/der.css">der.css</a>.</p>
	</div>
	<div class="view" data-view-type="latex">
		<p>LaTeX rendering coming soon.</p>
	</div>
</div>

<?php
}
?>

</div>
<hr>
<div class="row">
	<div class="col-md-6">
		<h2>Translations</h2>
			<ul class=list-unstyled>

<?php
foreach($body->translations as $translation) {
	print_link_to_sentence($translation);
}
?>

			</ul>
	</div>	

<?php
if ($is_user_logged_in && in_array($user_name, ['judge', 'analyst'])) {
?>

	<div class="col-md-6">
		<h2>Comments <small id="comment-indicator">saved</small></h2>
		<form>
		<textarea id="comment" class="form-control" rows="4"><?= htmlspecialchars($body->comment) ?></textarea>
		</form>
	</div>

<?php
}
?>

</div>

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

<script src=js/comment.js></script>
<script src=js/der.js></script>
<script src=js/views.js></script>

<?php
require('inc/foot.inc.php');
?>
