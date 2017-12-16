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

<p>Here you can download all BOWs (<i>bits of wisdom</i>) created by CCGweb
annotators so far. The download also contains mappings to the corresponding
<a href=http://pmb.let.rug.nl>Parallel Meaning Bank</a> document IDs.</p>

<a href=api.php?api_resource=bows>Download BOWs</a>

</div>

<?php
require('inc/foot.inc.php');
?>
