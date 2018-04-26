<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('inc/util.inc.php');
require('inc/config.inc.php');
require('inc/session.inc.php');

$sections = [
	'introduction' => 'Introduction',
	'arguments-and-modifiers' => 'Arguments and Modifiers',
	'argument-order' => 'Argument Order',
	'clause-types' => 'Clause Types',
	'conditional-clauses' => 'Conditional Clauses',
	'contractions' => 'Contractions',
	'coordination' => 'Coordination',
	'demonyms' => 'Demonyms',
	'imperatives' => 'Imperatives',
	'possessives' => 'Possessives',
	'pro-drop' => 'Pro-drop',
	'pronouns' => 'Pronouns',
	'punctuation' => 'Punctuation',
	'specific-lexical-items' => 'Specific Lexical Items',
	'tokenization' => 'Tokenization',
];

$updated_sections = ['pronouns', 'imperatives', 'arguments-and-modifiers', 'possessives'];

if (!isset($_GET['section']) || !isset($sections[$_GET['section']])) {
	header('Location: ' . url('manual.php', ['section' => 'introduction']));
	die();
}

$section = $_GET['section'];
$section_title = $sections[$section];

$title = 'CCGWeb - Manual - ' . strip_tags($section_title);
require('inc/head.inc.php');
?>

<div class=container>
	<h2>Manual</h2>
	<hr>
	<div class=row>
		<div class=col-md-3>
			<ul class="nav nav-pills nav-stacked">
		
<?php foreach ($sections as $s => $t) { ?>
		
					<li role="presentation"<?= $s == $section ? ' class="active"' : '' ?>>
						<a href=<?= url('manual.php', ['section' => $s]) ?>><?= $t ?>

<?php if (in_array($s, $updated_sections)) { ?>

							<span class="label label-danger">updated</span>

<?php } ?>

						</a>
					</li>
		
<?php } ?>
		
<li role="presentation"><a href="mailto:evang@hhu.de?subject=<?= rawurlencode('CCGWeb: update request') ?>"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> request update</a></li>
			</ul>
		</div>
		<div class=col-md-9>
		
<?php require('inc/manual/' . $section . '.inc.php'); ?>
		
		</div>
	</div>
</div>

<?php
require('inc/foot.inc.php');
?>
