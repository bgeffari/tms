<?php
	session_start();
		unset($_SESSION['me']);
		session_destroy();
		header("location:login.php");
?>