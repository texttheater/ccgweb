<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- jQuery UI -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<!-- Bootstrap scripts -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Our scripts -->
<script src="js/util.js"></script>
<script>
<?php
if ($is_user_logged_in) {
	echo "const isUserLoggedIn = true\n";
	echo "const userName = ". json_encode($user_name) . "\n";
} else {
	echo "const isUserLoggedIn = false\n";
}
?>
let busy = false;
</script>
