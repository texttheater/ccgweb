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

/**
 * Make an API call. Automatically passes a cookie with the session ID, if any.
 * @param $resorce
 *   The resource identifier.
 * @param $action
 *   'get' for a 'GET' request or a specific action for a 'POST' request. In
 *   the latter case, 'api_action' => $action will be added to $params.
 * @param $params
 *   An associative array with the parameters to pass to the API.
 * @return
 *   A Requests_Response object.
 */
function api($resource, $action, $params) {
	global $api;
	$headers = [];

	if (isset($_SESSION['ccgweb_api_session_id'])) {
		$headers['Cookie'] = 'session_id = ' .
			$_SESSION['ccgweb_api_session_id'];
	}

	if (strtolower($action) == 'get') {
		$query = http_build_query($params, null,
			ini_get('arg_separator.output'), PHP_QUERY_RFC3986);
		return Requests::get($api . '/' . $resource . '?' . $query,
			$headers);
	} else {
		$params['api_action'] = $action;
		return Requests::post($api . '/' . $resource, $headers,
			$params);
	}
}

function url($page, $params) {
	$result = $page;
	$paramstrings = [];

	foreach ($params as $k => $v) {
		$paramstrings[] = rawurlencode($k) . '=' . rawurlencode($v);
	}

	if (!empty($paramstrings)) {
		$result .= '?' . join('&', $paramstrings);
	}

	return $result;
}

function print_link_to_sentence($sentence) {
	?>
	<li>
		<span class="label label-default">
			<?= htmlspecialchars($sentence->lang) ?>
		</span>
		&nbsp;
		<a href=sentence.php?lang=<?= rawurlencode($sentence->lang) ?>&sentence=<?= rawurlencode($sentence->sentence) ?>>
			<?= htmlspecialchars($sentence->sentence) ?>
		</a>
	
	<?php
	if ($sentence->done) {
	?>
	
	<span class="label label-success">marked correct</span>
	<?php
	}
	?>

	</li>
	<?php
}

?>
