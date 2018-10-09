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

function print_link_to_sentence($sentence, $show_needs_annotation_labels = false) {
	?>
	<li>
		<span class="label label-default">
			<?= htmlspecialchars($sentence->lang) ?>
		</span>
		&nbsp;
		<?php if ($sentence->done) { ?>
		<span class="label label-success">marked correct</span>
		<?php } ?>
		<?php if ($show_needs_annotation_labels && $sentence->needs_annotation) { ?>
		<span class="label label-warning">needs annotation</span>
		<?php } ?>
		&nbsp;
		<span dir="auto">
			<a href=sentence.php?lang=<?= rawurlencode($sentence->lang) ?>&sentence=<?= rawurlencode($sentence->sentence) ?>>
				<?= htmlspecialchars($sentence->sentence) ?>
			</a>
		</span>
	</li>
	<?php
}

function selected($a, $b) {
	if ($a == $b) {
		return ' selected';
	} else {
		return '';
	}
}

function is_human_user_id($user_id) {
	if ($user_id == 'auto') {
		return false;
	}

	if ($user_id == 'proj') {
		return false;
	}

	if ($user_id == 'xl') {
		return false;
	}

	if ($user_id == 'judge') {
		return false;
	}

	if ($user_id == 'testuser') {
		return false;
	}

	return true;
}
?>
