<?php
error_reporting(-1);
ini_set("display_errors", 1);
require('vendor/autoload.php');
require('inc/util.inc.php');
require('inc/config.inc.php');
require('inc/session.inc.php');

$title = 'CCGweb - Download';
require('inc/head.inc.php');
?>

<div class=container>

<h2>Download</h2>

<p>Here you can download all annotations completed (marked correct) by
annotators so far. They come in a JSON document containing derivations in a
Boxer-style XML format. It also contains mappings to the corresponding
<a href=http://pmb.let.rug.nl>Parallel Meaning Bank</a> document IDs.</p>

<a href=api.php?api_resource=download>Download annotations</a>

<h3>Supplemental Data</h3>

<p>To provide a greater number of derivations (e.g., for training parsers), we
also release the gold syntactic CCG derivations created so far in the <a
href="https://pmb.let.rug.nl/">Parallel Meaning Bank</a>. These do not follow
the annotation guidelines in detail due to their focus on semantics, nor have
they been adjudicated, but instead corrected by a single annotator.  However,
they are much greater in number. For an even greater number, we also release
<i>partially corrected</i> (“silver”) derivations, meaning that the annotator
made at least one change to the automatically created derivation.</p>

<a href=ccgweb_supplemental.zip>Download supplemental data</a>

</div>

<?php
require('inc/foot.inc.php');
?>
