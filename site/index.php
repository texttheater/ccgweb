<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('inc/util.inc.php');
require('inc/config.inc.php');

require('inc/session.inc.php');

if (!isset($_GET['sentence']) || !$_GET['sentence']) {
	header('Location: ./?sentence=' . rawurlencode("I don't want to be famous."));
	die();
}

if (strlen($_GET['sentence']) > 1024) {
	die('ERROR: sentence too long. Only 1024 bytes allowed.');
}

$sentence = $_GET['sentence'];

try {
	$response = Requests::get("$api/sentences/" . rawurlencode($sentence) . "/auto");
} catch (Requests_Exception $e) {
	die('ERROR: could not connect to REST server. Is it running?');
}

if (!$response->success) {
	die('ERROR: bad API response status');
}

$parser_parse = $response->body;

if ($is_user_logged_in) {
	try {
		$response = Requests::get("$api/sentences/" . rawurlencode($sentence) . "/" . $user_name);
	} catch (Requests_Exception $e) {
		die('ERROR: could not connect to REST server. Is it running?');
	}
	
	if (!$response->success) {
		die('ERROR: bad API response status');
	}
	
	$user_parse = $response->body;
}

$title = 'CCGWeb';

require('inc/head.inc.php');
?>

<h2>Sentence</h2>

<p><?= htmlspecialchars($sentence); ?></p>

<h2>Parse</h2>

<ul class="nav nav-tabs">
	<li class="<?= $is_user_logged_in ? '' : 'active' ?>"><a data-toggle=tab href=#parses_parser>Parser</a></li>
	<?php if ($is_user_logged_in) { ?>
		<li class=active><a data-toggle=tab href=#parses_mine>Mine</a></li>
	<?php } ?>
</ul>
<div class=tab-content>
	<div id=parses_parser class="tab-pane <?= $is_user_logged_in ? '' : 'active' ?>">
		<?= xslTransform('xsl/der.xsl', $parser_parse) ?>
	</div>
	<?php if ($is_user_logged_in) { ?>
		<div id=parses_mine class="tab-pane active">
			<?= xslTransform('xsl/der.xsl', $user_parse) ?>
		</div>
	<?php } ?>
</div>

<?php
require('inc/foot.inc.php');
?>
