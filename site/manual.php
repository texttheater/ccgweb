<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('inc/util.inc.php');
require('inc/config.inc.php');
require('inc/session.inc.php');

$sections = [
	'introduction' => 'Introduction',
	'argument-order' => 'Argument Order',
	'clause-types' => 'Clause Types',
	'conditional-clauses' => 'Conditional Clauses',
	'contractions' => 'Contractions',
	'coordination' => 'Coordination',
	'demonyms' => 'Demonyms',
	'imperatives' => 'Imperatives',
	'possessives' => 'Possessives',
	'pro-drop' => 'Pro-drop',
	'punctuation' => 'Punctuation',
	'reflexive-pronouns' => 'Reflexive Pronouns',
	'specific-lexical-items' => 'Specific Lexical Items',
];

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
	<!--<div style="height: 20px;"></div>-->
	<div class="panel panel-default">
		<div class="panel-body">
			<div class=row>
				<div class=col-md-3>
					<div class=list-group>
		
		<?php foreach ($sections as $s => $t) { ?>
		
						<a class="list-group-item<?= $s == $section ? ' active' : '' ?>" href=<?= url('manual.php', ['section' => $s]) ?>><?= $t ?></a>
		
		<?php } ?>
		
					</div>
				</div>
				<div class=col-md-9>
		
		<?php require('inc/manual/' . $section . '.inc.php'); ?>
		
				</div>
			</div>
		</div>
	</div>
</div>

<?php
require('inc/foot.inc.php');
?>
