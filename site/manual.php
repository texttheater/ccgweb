<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('inc/util.inc.php');
require('inc/data.inc.php');
require('inc/config.inc.php');
require('inc/session.inc.php');

$updated_sections = [];

if (!isset($_GET['section']) || !isset($manual_sections[$_GET['section']])) {
	header('Location: ' . url('manual.php', ['section' => 'introduction']));
	die();
}

$section = $_GET['section'];
$section_title = $manual_sections[$section];

$title = 'CCGWeb - Manual - ' . strip_tags($section_title);
require('inc/head.inc.php');
?>

<div class=container>
	<h2>Manual</h2>
	<hr>
	<div class=row>
		<div class=col-md-3>
			<ul class="nav nav-pills nav-stacked">
		
<?php foreach ($manual_sections as $s => $t) { ?>
		
					<li role="presentation"<?= $s == $section ? ' class="active"' : '' ?>>
						<a href=<?= url('manual.php', ['section' => $s]) ?>><?= $t ?>

<?php if (in_array($s, $updated_sections)) { ?>

							<span class="label label-danger">updated</span>

<?php } ?>

						</a>
					</li>
		
<?php } ?>
		
<li role="presentation"><a href="https://github.com/texttheater/ccgweb/issues/new"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> request update</a></li>
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
