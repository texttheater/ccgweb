<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('inc/util.inc.php');
require('inc/config.inc.php');
require('inc/session.inc.php');

$title = 'CCGweb - About';
require('inc/head.inc.php');
?>

<div class=container>

<h2>About</h2>

<p>CCGweb is an annotation platform for Combinatory Categorial Grammar. The
goal is to create a multilingual corpus of sentences annotated in the style of
<a href=https://dl.acm.org/citation.cfm?id=1858703>CCGrebank</a>.</p>

<p>All sentences are <a href=https://creativecommons.org/licenses/by/2.0/>CC-BY</a>
<a href=https://tatoeba.org>Tatoeba</a>.</p>

<p>All annotations are <a href=https://creativecommons.org/licenses/by/2.0/>CC-BY</a>
the CCGweb contributors.</p>

<p>CCGweb is described in the following paper:</p>

<p>Kilian Evang, Lasha Abzianidze, Johan Bos (2019): CCGweb: a New Annotation
Tool and a First Quadrilingual CCG Treebank. In <i>Proceedings of the 13th
Linguistic Annotation Workshop</i>. Florence, Italy: Association for
Computational Linguistics.</p>

<p><a href=https://github.com/texttheater/ccgweb>Source code/issue tracker</a></p>

</div>

<?php
require('inc/foot.inc.php');
?>
