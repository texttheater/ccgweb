<?php
function xslTransform($stylesheetPath, $xml) {
	$stylesheet = new DOMDocument();
	$stylesheet->load($stylesheetPath);
	$doc = new DOMDocument();
	$doc->loadXML($xml);
	$proc = new XSLTProcessor();
	$proc->importStyleSheet($stylesheet);
	return $proc->transformToXML($doc);
}
?>
