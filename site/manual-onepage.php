<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('inc/util.inc.php');
require('inc/data.inc.php');
require('inc/config.inc.php');
require('inc/session.inc.php');

if (!$is_user_privileged) {
	header('Location: user.php');
	die();
}

$title = 'Annotation Manual';
require('inc/head.inc.php');
?>

<div class="container-fluid">
	<h2>Manual</h2>
	<hr>
	<h3>Table of Contents</h3>
	<ol>

<?php
foreach ($manual_sections as $s => $t) {
?>

		<li><a href="#<?= $s ?>"><?= htmlspecialchars($t) ?></a></li>

<?php
}
?>

	</ol>
	<hr>
		
<?php
foreach ($manual_sections as $s => $t) {
?>

	<h3 id="<?= $s ?>"><?= htmlspecialchars($t) ?></h3>

<?php
	require('inc/manual/' . $s. '.inc.php');
?>

	<hr>

<?php
}
?>

</div>

<?php
require('inc/foot.inc.php');
?>
