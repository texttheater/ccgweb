<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('inc/util.inc.php');
require('inc/config.inc.php');
require('inc/session.inc.php');

$title = 'CCGWeb - About';
require('inc/head.inc.php');
?>

<div class=container>

<h2>About</h2>

<p>CCGWeb is an annotation platform for Combinatory Categorial Grammar. It is
currently in closed beta.</p>

<p>All sentences are <a href=https://creativecommons.org/licenses/by/2.0/>CC-BY</a>
<a href=https://tatoeba.org>Tatoeba</a>.</p>

<p>All annotations are <a href=https://creativecommons.org/licenses/by/2.0/>CC-BY</a>
the CCGWeb contributors.</p>

<p><a href=https://github.com/texttheater/ccgweb>Source code/issue tracker</a></p>

</div>

<?php
require('inc/foot.inc.php');
?>
