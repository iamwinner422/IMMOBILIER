<?php
	session_start();
	$_SESSION = array();
	session_destroy();
	setcookie('__lingoser');
	echo '<script>document.location.replace("../index.php");</script>';
?>