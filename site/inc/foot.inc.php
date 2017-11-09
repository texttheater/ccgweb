		</main>

		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<!-- Bootstrap scripts -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<!-- Our scripts -->
		<script>
<?php
echo "const api = " .json_encode($api) . "\n";

if ($is_user_logged_in) {
	echo "const isUserLoggedIn = true\n";
	echo "const userName = ". json_encode($user_name) . "\n";
} else {
	echo "const isUserLoggedIn = false\n";
}

echo "const sentence = " . json_encode($sentence) . "\n";
?>
		</script>
		<script src=js/der.js></script>
	</body>
</html>
