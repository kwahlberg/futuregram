<?php

require_once 'phplib/app/models/DB.php';
$db = new DB();
if(!empty($_POST["username"])) {
	$result = $db->query("SELECT * FROM users WHERE email='" . $_POST["email"] . "'");

	if(!empty($result)) echo "<span class='status-not-available'> Username Not Available.</span>";
	else echo "<span class='status-available'> Username Available.</span>";
}
?>