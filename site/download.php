<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('inc/util.inc.php');
require('inc/config.inc.php');
require('inc/session.inc.php');

$title = 'CCGWeb - Download';
require('inc/head.inc.php');
?>

<div class=container>

<h2>Download</h2>

<p>Here you can download all annotations completed (marked correct) by
annotators so far. They come in a JSON document containing derivations in a
Boxer-style XML format. It also contains mappings to the corresponding
<a href=http://pmb.let.rug.nl>Parallel Meaning Bank</a> document IDs.</p>

<a href=api.php?api_resource=download>Download annotations</a>

</div>

<?php
require('inc/foot.inc.php');
?>
