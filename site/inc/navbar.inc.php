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
				<a href="manual.php">Manual</a>
			</li>
			<li>
				<a href="download.php">Download</a>
			</li>

<?php if ($is_user_logged_in && $user_name == 'judge')
{
?>

			<li>
				<a href="monitor.php">Monitor</a>
			</li>

<?php
}
?>

			<li>
				<a target="_blank" href="https://www.uni-duesseldorf.de/home/footer/datenschutz.html">Privacy Policy</a>
			</li>

		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li>
<?php if (basename($_SERVER['SCRIPT_FILENAME']) == 'user.php') { ?>
<?php } elseif ($is_user_logged_in) { ?>
				<a href=user.php><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?= htmlspecialchars($user_name) ?></a>
<?php } else { ?>
				<a href=user.php>Sign in</a>
<?php } ?>
			</li>
		</ul>
	</div>
</nav>
