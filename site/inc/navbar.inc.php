<nav class="navbar navbar-inverse navbar-static-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href=".">CCGWeb</a>
		</div>
		<ul class="nav navbar-nav">
			<li>
				<a href="about.php">About</a>
			</li>
			<li>
				<a href="download.php">Download</a>
			</li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li>
<?php
if (basename($_SERVER['SCRIPT_FILENAME']) == 'user.php') {
} elseif ($is_user_logged_in) {
	echo '<a href=user.php><span class="glyphicon glyphicon-user" aria-hidden="true"></span> ' . htmlspecialchars($user_name) . "</a>\n";
} else {
	echo "<a href=user.php>Sign in</a>\n";
}
?>
			</li>
		</ul>
	</div>
</nav>
