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
	$response = api("sentences/$lang/" . rawurlencode($sentence) . '/auto', 'get', []);
} catch (Requests_Exception $e) {
	die('ERROR: could not connect to REST server. Is it running?');
}

if (!$response->success) {
	die('ERROR: bad API response status');
}

$parser_sentence = json_decode($response->body);

if ($is_user_logged_in) {
	try {
		$response = api("sentences/$lang/" . rawurlencode($sentence) . '/' . rawurlencode($user_name), 'get', []);
	} catch (Requests_Exception $e) {
		die('ERROR: could not connect to REST server. Is it running?');
	}
	
	if (!$response->success) {
		die('ERROR: bad API response status');
	}
	
	$user_sentence = json_decode($response->body);
}

$title = 'CCGWeb - ' . htmlspecialchars($sentence);

require('inc/head.inc.php');
?>

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
		<?= xslTransform('xsl/der.xsl', $parser_sentence->derxml) ?>
	</div>
	<?php if ($is_user_logged_in) { ?>
		<div id=parses_mine class="tab-pane active">
			<?= xslTransform('xsl/der.xsl', $user_sentence->derxml) ?>
			<p>&nbsp;</p>
			<div class="well well-sm <?= $user_sentence->marked_correct ? 'well-success' : '' ?>">
				<div class=checkbox style="display: inline;" id=mark-correct>
					<label>
						<input type=checkbox <?= $user_sentence->marked_correct ? 'checked' : '' ?>> mark correct
					</label>
				</div>
			</div>
		</div>
	<?php } ?>
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
